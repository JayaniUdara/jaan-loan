<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DailyCollection;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyCollectionController extends Controller
{


    public function index()
{
    // Get today's date at the start of the day
    $today = Carbon::now()->startOfDay();

    $collections = DailyCollection::with('loan')->get();


            // Fetch collections for today with relationships
    $todayscollections = DailyCollection::with('loan')
    ->whereDate('collection_date', $today)
    ->get();
    // Calculate total cash collected today (status = 'collected')
    $totalCollected = $todayscollections
        ->where('status', 'collected')
        ->sum('amount'); // Assuming 'amount' is the column for collection value

    // Calculate total pending collections today (status = 'pending')
    $totalPending = $todayscollections
        ->where('status', 'pending')
        ->sum('amount');

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
    {
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
    
            // Update the loan's total due

        }
    }
    

    public function approveTodaysCollections(Request $request)
    {
        $request->validate([
            'approved_by' => 'required|exists:users,id', // Ensure the approver is a valid user
        ]);
    
    
        // Update today's collections
        $updatedCount = DailyCollection::whereDate('collection_date', today())
            ->update([
                'is_approved' => '1',
                'approved_by' => $request->approved_by,
            ]);
    
            $this->updateLoansTotalDue();
        return redirect()->back()->with('success', "$updatedCount collections have been approved.");
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
                $loan->outstanding_balance = max(0, $loan->outstanding_balance - $validatedData['amount_collected']);
                $loan->remaining_installments = max(0, $loan->remaining_installments - 1);
        
                $loan->save();

        return redirect()->route('daily-collections.index')->with('success', 'Daily collection recorded successfully!');
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