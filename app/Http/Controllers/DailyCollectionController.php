<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DailyCollection;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyCollectionController extends Controller
{


    public function index()
{
    // Get today's date at the start of the day
    $today = Carbon::now()->startOfDay();

    $collections = DailyCollection::with(['loan', 'customer'])->get();
//dd($collections);

            // Fetch collections for today with relationships
    $todayscollections = DailyCollection::with('loan')
    ->whereDate('collection_date', $today)
    ->get();
    // Calculate total cash collected today (status = 'collected')
    $totalCollected = $todayscollections
        ->where('status', 'collected')
        ->sum('amount_collected'); // Assuming 'amount' is the column for collection value

    // Calculate total pending collections today (status = 'pending')
    $totalPending = $todayscollections
        ->where('status', 'pending')
        ->sum('amount_collected');

    // Pass data to the view
    return view('daily_collections.index', [
        'collections' => $collections,
        'totalCollected' => $totalCollected,
        'totalPending' => $totalPending
    ]);
}

    public function createPast()
    {
      
        $loans = Loan::all();
        $customers = Customer::all();
        return view('daily_collections.createpast', compact('loans', 'customers'));
    }
    

    private function updateLoansTotalDue()
    {//dd('test');
        $loans = Loan::all();
    
        foreach ($loans as $loan) {
            // Get the pending collections up until today
            $pendingCollections = DailyCollection::where('loan_id', $loan->id)
                ->where('status', 'pending')
                ->whereDate('collection_date', '<=', today())
                ->get();
    
            $totalPendingAmount = $pendingCollections->sum('amount_collected');
            $installmentAmount = (($loan->amount*0.01 + $loan->amount)/($loan->total_installments));
    
            // Add 3% interest if pending exceeds 3 installments
            if ($totalPendingAmount > (3 * $installmentAmount)) {
                // Find the next pending collection (next installment)
                $nextCollection = DailyCollection::where('loan_id', $loan->id)
                    ->where('status', 'pending')
                    ->whereDate('collection_date', '>', today()) // Target the next day's installment
                    ->orderBy('collection_date', 'asc') // Ensure we get the next installment
                    ->first();
                    
                if ($nextCollection) {
                    // Calculate and add the 3% interest to the next installment's collection amount
                    $interest = $loan->total_due * 0.03;
                    $nextCollection->amount_collected =$installmentAmount+ $interest; // Update the amount_collected
                    $nextCollection->save();


                    $loan->total_due = $totalPendingAmount + $installmentAmount +$interest; // Add the current installment amount
                    $loan->save();
                }


            }
    // Retrieve today's collected amounts related to the loan
$collectedToday = DailyCollection::where('loan_id', $loan->id)
->where('status', 'collected')
->whereDate('updated_at', today())
->get(); // Fetch the records

// Ensure we get the actual numeric value of outstanding_balance
$orig_outstanding_balance = (float) $loan->getAttribute('outstanding_balance');

// Calculate total collected amount for today
$collectedAmount = $collectedToday->sum('amount_collected'); // Sum up the collected amounts
//dd($collectedAmount);
// Update outstanding balance by reducing today's collected amount
$loan->outstanding_balance = max($orig_outstanding_balance - $collectedAmount, 0); // Prevent negative balance

// Save the updated loan record
$loan->save();

        }

        return redirect()->route('daily-collections.index')->with('success', "Collections have been approved successfully.");


    }
    

    public function approveTodaysCollections(Request $request)
    {//dd($request->all());
        $request->validate([
            'approved_by' => 'required|exists:users,id', // Ensure the approver is a valid user
        ]);
    
    
        // Update today's collections
        $updatedCount = DailyCollection::whereDate('collection_date', today())
            ->update([
                'is_approved' => '1',
                'approved_by' => auth()->id(),
            ]);
    
            $this->updateLoansTotalDue();
            return redirect()->route('daily-collections.index')->with('success', "Collections have been approved successfully.");

    }
    public function storePast(Request $request)
    {
        $validatedData = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'customer_id' => 'required|exists:customers,id',
            'amount_collected' => 'required|numeric|min:0',
            'collection_date' => 'required|date',
            'status' => 'required|in:collected,pending',
            'installment_number' => 'required|integer|min:1',
        ]);
    
        DailyCollection::create([
            'loan_id' => $validatedData['loan_id'],
            'customer_id' => $validatedData['customer_id'],
            'amount_collected' => $validatedData['amount_collected'],
            'collection_date' => $validatedData['collection_date'],
            'notes' => $request->notes ?? null,
            'installment_number' => $validatedData['installment_number'],
            'user_id' => auth()->id(),
            'status' => $validatedData['status'],
        ]);
    

                // Update the loan record
                $loan = Loan::findOrFail($validatedData['loan_id']);

                // Update outstanding balance and remaining installments
                if ($validatedData['status'] === 'collected') {
                $loan->outstanding_balance = max(0, $loan->outstanding_balance - $validatedData['amount_collected']);
                }
                $loan->remaining_installments = max(0, $loan->remaining_installments - 1);
        
                $loan->save();

        return redirect()->route('daily-collections.index')->with('success', 'Daily collection recorded successfully!');
    }
    

    public function skipToday(Request $request)
    {
        $today = now()->toDateString();
        $collections = DailyCollection::where('collection_date', $today)->get();
    
        if ($collections->isEmpty()) {
            return redirect()->route('daily-collections.index')->with('error', 'No collections found for today.');
        }
    
        try {
            DB::beginTransaction();
    
            // Update today's collections by shifting collection_date by one day
       
    
            // Fetch the affected loan IDs
            $loanIds = $collections->pluck('loan_id')->unique();
    
            foreach ($loanIds as $loanId) {
                $futureCollections = DailyCollection::where('loan_id', $loanId)
                    ->where('collection_date', '>', $today)
                    ->orderBy('collection_date', 'asc')
                    ->get();
    
                foreach ($futureCollections as $collection) {
                    $collection->collection_date = Carbon::parse($collection->collection_date)->addDay();
                    $collection->save();
                }
            }

            foreach ($collections as $collection) {
                $collection->collection_date = Carbon::parse($collection->collection_date)->addDay();
                $collection->save();
            }
    
            DB::commit();
            return redirect()->route('daily-collections.index')->with('success', 'Today’s collections skipped successfully, and future collections adjusted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('daily-collections.index')->with('error', 'Failed to skip today’s collections: ' . $e->getMessage());
        }
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount_collected' => 'required|numeric|min:0',
            'status' => 'required|in:collected,pending',
            'notes' => 'nullable|string'
        ]);
        
        $today = Carbon::now()->startOfDay();
        
        // Find or create today's collection record
        $collection = DailyCollection::firstOrNew([
            'loan_id' => $request->loan_id,
            'collection_date' => $today
        ]);
        
        $collection->fill([
            'user_id' => auth()->id(),
            'customer_id' => Loan::find($request->loan_id)->customer_id,
            'amount_collected' => $request->amount_collected,
            'status' => $request->status,
            'notes' => $request->notes,
            'approved_by' => auth()->id(),
            'is_approved' => true
        ]);
        
        $collection->save();
        
        // Update loan's outstanding balance if collected
        if ($request->status === 'collected') {
            $loan = Loan::find($request->loan_id);
            $loan->outstanding_balance -= $request->amount_collected;
            $loan->remaining_installments -= 1;
            $loan->save();
        }
        
        return redirect()->back()->with('success', 'Collection recorded successfully!');
    }
}