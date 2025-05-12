<?php
namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Guarantor;
use App\Models\Customer;
use App\Models\User;
use App\Models\DailyCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index()
    {
        // Eager load relationships and retrieve the data
        $loans = Loan::with('customer', 'approvedBy', 'guarantors')->get();
       // dd($loans); // Check the retrieved dataset
        return view('loans.index', compact('loans'));
    }
    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $customers = Customer::all(); // Retrieve all customers for selection
        return view('loans.create', compact('customers'));
    }
    public function view($id)
    {
        $loan = Loan::with('guarantors', 'customer', 'approvedBy')
            ->withCount(['dailyCollections as unpaid_installments_count' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->with(['dailyCollections' => function ($query) {
                $query->where('status', 'collected')->orderBy('collection_date', 'desc')->limit(1);
            }])
            ->findOrFail($id);
        
        $lastCollection = $loan->dailyCollections->first();
        $loan->last_paid_date = $lastCollection ? $lastCollection->collection_date : null;
        $loan->last_paid_amount = $lastCollection ? $lastCollection->amount_collected : null;
        
        return view('loans.view', compact('loan'));
    }


    public function createPast()
    {
        $customers = Customer::all(); // Retrieve all customers for selection
        $users = User::all(); // Retrieve all users for selection
        return view('loans.createpast', compact('customers','users'));
    }

    /**
     * Store a new loan with guarantors in storage.
     */

     public function store(Request $request)
    { //dd($request->all());
        // Validate the incoming data
        try {
        $validatedData = $request->validate([
            'loan_custom_id' => 'nullable|string|max:255|unique:loans,loan_custom_id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'installment_duration' => 'required|in:daily,weekly',
            'guarantors.*.name' => 'required|string|max:255',
            'guarantors.*.contact' => 'required|string|max:255',
            'guarantors.*.address' => 'required|string|max:255',
            'guarantors.*.national_id' => 'nullable|string|max:255',
            'guarantors.*.relationship' => 'nullable|string|max:255',
            'guarantors.*.date_of_birth' => 'nullable|date',
            'guarantors.*.occupation' => 'nullable|string|max:255',
            'guarantors.*.annual_income' => 'nullable|numeric|min:0',
            'guarantors.*.additional_notes' => 'nullable|string|max:1000',
        ], [
            'customer_id.required' => 'The Customer ID is required.',
            'amount.required' => 'The loan amount is required.',
            'installment_duration.required' => 'Installment duration is required.',
            'guarantors.*.name.required' => 'Guarantor name is required.',
            'guarantors.*.contact.required' => 'Guarantor contact is required.',
            'guarantors.*.address.required' => 'Guarantor address is required.',
        ]);

    }catch (\Illuminate\Validation\ValidationException $e) {
        // Collect all error messages as a single string
        $errorMessages = implode(' ', $e->validator->errors()->all());

        // Redirect with errors as a session variable
        return redirect()->back()->withInput()->with('error', $errorMessages);// Replace with your intended route
             // Store errors as a session variable

    }
  // dd($validatedData);
        try {
            // Calculate total with interest (10% per month for 2 months)
            $interestRate = 0.10; // 10% per month
            $months = 2; // 2 months
            $totalWithInterest = $validatedData['amount'] + ($validatedData['amount'] * $interestRate * $months);

            // Calculate installment amount
            $installmentAmount = $validatedData['installment_duration'] === 'daily'
                ? $totalWithInterest / 60 // 60 days
                : $totalWithInterest / 8; // 8 weeks

                $installment_duration = $validatedData['installment_duration'] === 'daily'
                ? 1 // 60 days
                : 7; // 8 weeks

                $numInstallments = $validatedData['installment_duration'] === 'daily'
                ? 60 // 60 days
                : 8; // 8 weeks
            // Create the loan
            $loan = Loan::create([
                'loan_custom_id' => $validatedData['loan_custom_id'],
                'customer_id' => $validatedData['customer_id'],
                'amount' => $validatedData['amount'],
                'interest_rate' => 10,
                'total_due' => 0,
                'installment_duration' => $installment_duration,
                'total_installments' => $numInstallments,
                'remaining_installments' => $numInstallments,
                'outstanding_balance' => $totalWithInterest, // Default to full amount
            ]);

            // Loop through each guarantor and attach to the loan
            foreach ($validatedData['guarantors'] as $guarantorData) {
                $loan->guarantors()->create([
                    'name' => $guarantorData['name'],
                    'contact' => $guarantorData['contact'],
                    'address' => $guarantorData['address'],
                    'national_id' => $guarantorData['national_id'] ?? null,
                    'relationship' => $guarantorData['relationship'] ?? null,
                    'date_of_birth' => $guarantorData['date_of_birth'] ?? null,
                    'occupation' => $guarantorData['occupation'] ?? null,
                    'annual_income' => $guarantorData['annual_income'] ?? null,
                    'additional_notes' => $guarantorData['additional_notes'] ?? null,
                ]);
            }

            return redirect()->route('loans.index')->with('success', 'Loan and guarantors added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }


    public function storePast(Request $request)
    {//dd($request->all());
        // Validate the incoming data
        $validatedData = $request->validate([
            'loan_custom_id' => 'required|string|max:255|unique:loans,loan_custom_id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'loan_approved_date' => 'nullable|date',
            'loan_end_date' => 'nullable|date|after_or_equal:loan_approved_date',
            'approved_by' => 'nullable|string|max:255',
            'remaining_installments' => 'required|numeric|min:0',
            'outstanding_balance' =>'required|numeric|min:0',
            'installment_duration' => 'required|in:daily,weekly',
            'guarantors.*.name' => 'required|string|max:255',
            'guarantors.*.contact' => 'required|string|max:255',
            'guarantors.*.address' => 'required|string|max:255',
            'guarantors.*.national_id' => 'nullable|string|max:255',
            'guarantors.*.relationship' => 'nullable|string|max:255',
            'guarantors.*.date_of_birth' => 'nullable|date',
            'guarantors.*.occupation' => 'nullable|string|max:255',
            'guarantors.*.annual_income' => 'nullable|numeric|min:0',
            'guarantors.*.additional_notes' => 'nullable|string|max:1000',
        ], [
            'customer_id.required' => 'The Customer ID is required.',
            'amount.required' => 'The loan amount is required.',
            'installment_duration.required' => 'Installment duration is required.',
            'guarantors.*.name.required' => 'Guarantor name is required.',
            'guarantors.*.contact.required' => 'Guarantor contact is required.',
            'guarantors.*.address.required' => 'Guarantor address is required.',
        ]);
  // dd($validatedData);
        try {
            // Calculate total with interest (10% per month for 2 months)
            $interestRate = 0.10; // 10% per month
            $months = 2; // 2 months
            $totalWithInterest = $validatedData['amount'] + ($validatedData['amount'] * $interestRate * $months);

            // Calculate installment amount
            $installmentAmount = $validatedData['installment_duration'] === 'daily'
                ? $totalWithInterest / 60 // 60 days
                : $totalWithInterest / 8; // 8 weeks

                $installment_duration = $validatedData['installment_duration'] === 'daily'
                ? 1 // 60 days
                : 7; // 8 weeks

                $numInstallments = $validatedData['installment_duration'] === 'daily'
                ? 60 // 60 days
                : 8; // 8 weeks

               
            // Create the loan
            $loan = Loan::create([
                'loan_custom_id' => $validatedData['loan_custom_id'],
                'customer_id' => $validatedData['customer_id'],
                'amount' => $validatedData['amount'],
                'interest_rate' => 10,
                'is_approved' => true,
                'status' => 'approved',
                'installment_duration' => $installment_duration,
                'total_installments' => $numInstallments,
                'remaining_installments' => $validatedData['remaining_installments'],
                'outstanding_balance' =>$validatedData['outstanding_balance'],
                'approved_by' => 1,
            ]);
           // dd($loan);
            // Loop through each guarantor and attach to the loan
            foreach ($validatedData['guarantors'] as $guarantorData) {
                $loan->guarantors()->create([
                    'name' => $guarantorData['name'],
                    'contact' => $guarantorData['contact'],
                    'address' => $guarantorData['address'],
                    'national_id' => $guarantorData['national_id'] ?? null,
                    'relationship' => $guarantorData['relationship'] ?? null,
                    'date_of_birth' => $guarantorData['date_of_birth'] ?? null,
                    'occupation' => $guarantorData['occupation'] ?? null,
                    'annual_income' => $guarantorData['annual_income'] ?? null,
                    'additional_notes' => $guarantorData['additional_notes'] ?? null,
                ]);
            }

            return redirect()->route('loans.index')->with('success', 'Loan and guarantors added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    /**
     * Show the form for editing a loan.
     */
    public function edit($id)
    {
        $loan = Loan::with('guarantors')->findOrFail($id);
        $customers = Customer::all();
        $users = User::all();
        return view('loans.edit', compact('loan', 'customers','users'));
    }
    public function settle($id)
    {
        try {
            // Find the loan
            $loan = Loan::findOrFail($id);
    
            // Get the current date as the settlement date
            $settlementDate = Carbon::now();
    
            // Update loan details
            $loan->update([
                'status' => 'settled',
                'loan_end_date' => $settlementDate,
                'total_due' => 0,
                'outstanding_balance' => 0,
                'remaining_installments' => 0,
            ]);
    
            // Delete future daily collections
            DailyCollection::where('loan_id', $loan->id)
                ->where('collection_date', '>', $settlementDate)
                ->delete();
    
            return redirect()->route('loans.index')->with('success', 'Loan settled successfully. All future collection records have been deleted.');
        } catch (\Exception $e) {
            return redirect()->route('loans.index')->with('error', 'Failed to settle loan: ' . $e->getMessage());
        }
    }
        

    /**
     * Update the specified loan and its guarantors.
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric',
            'loan_approved_date' => 'nullable|date',
            'loan_end_date' => 'nullable|date',
            'outstanding_balance' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'installment_duration' => 'required|integer',
            'total_installments' => 'required|integer',
            'remaining_installments' => 'required|integer',
            'status' => 'required|in:pending,approved',
            'approved_by' => 'nullable|string',
            'guarantors.*.name' => 'required|string',
            'guarantors.*.contact' => 'required|string',
            'guarantors.*.address' => 'required|string',
        ]);

        // Update loan
        $loan->update($request->except('guarantors'));

        // Update or recreate guarantors
        $loan->guarantors()->delete(); // Delete existing guarantors
        if ($request->has('guarantors')) {
            foreach ($request->guarantors as $guarantor) {
                $loan->guarantors()->create($guarantor);
            }
        }

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully!');
    }

    /**
     * Approve a loan.
     */
    public function updateApprove(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        try {
            // Update loan status
            $loan->update([
                'loan_approved_date' => now(),
                'status' => 'approved',
                'is_approved' => true,
                'approved_by' => auth()->id(),
            ]);

            // Generate collection dates
            $total = $loan->total_installments;
            $startDate = Carbon::parse($loan->loan_approved_date)->startOfDay();
            $totalAmount = $loan->amount;
            $dailyInterest = $totalAmount * ($loan->interest_rate/100)*2 /$loan->total_installments;
            $remainingDays = ($loan->installment_duration + 1) * $loan->total_installments;
            $totalInterest = $totalAmount * $loan->interest_rate;
            $installmentAmount =  ($totalAmount + ($totalAmount * ($loan->interest_rate/100)*2))/$loan->total_installments;
$loanInsDuration = $loan->installment_duration;


$lastCollectionDate = null;
            // Create collection records for each date
            for ($i = 1; $i <= $total; $i++) {
                $collectionDate = $startDate->copy()->addDays($i * $loanInsDuration);
                $lastCollectionDate = $collectionDate;
                DailyCollection::create([
                    'loan_id' => $loan->id,
                    'user_id' => auth()->id(),
                    'customer_id' => $loan->customer_id,
                    'amount_collected' => $installmentAmount,
                    'status' => 'pending',
                    'collection_date' => $startDate->copy()->addDays($i * $loanInsDuration),
                    'notes' => 'null'
                ]);
            }
            if ($lastCollectionDate) {
                $loan->update(['loan_end_date' => $lastCollectionDate]);
            }

            return redirect()
                ->route('loans.index')
                ->with('success', 'Loan approved successfully and collection schedule created!');

        } catch (\Exception $e) {

            return redirect()
                ->route('loans.index')
                ->with('error', 'Failed to approve loan: ' . $e->getMessage());
        }
    }

    /**
     * Remove a loan and its guarantors.
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete(); // Cascading delete will remove guarantors

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully!');
    }
}
