<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\DailyCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;


class MobileController extends Controller
{
    public function index(Request $request)
    {
        // Get today's date at start of day for comparison
        $today = Carbon::now()->startOfDay();
    
        // Get filter and sort parameters
        $status = $request->input('status');
        $sortBy = $request->input('sort_by', 'loan_id'); // Default sorting by Loan ID
    
        // Query collections with filtering and sorting
        $collections = DailyCollection::with(['customer', 'loan'])
            ->whereDate('collection_date', $today)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy(
                $sortBy == 'customer' ? 'customer_id' : ($sortBy == 'amount_due' ? 'amount_collected' : $sortBy), 
                'asc'
            )
            ->get();
    
        return view('mobile.index', compact('collections'));
    }
    
    
    public function store(Request $request)
{ //dd($request->all());

    // Validate the request data
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
        'amount_collected' => 'required|numeric|min:0',
        'status' => 'required|in:collected,pending',
        'notes' => 'nullable|string',
    ]);

    // Retrieve the loan
    $loan = Loan::findOrFail($request->loan_id);

    // Find or create today's collection record
    $dailyCollection = DailyCollection::updateOrCreate(
        [
            'loan_id' => $loan->id,
            'collection_date' => Carbon::today()
        ],
        [
            'amount_collected' => $request->amount_collected,
            'status' => $request->status,
            'notes' => $request->notes,
           
        ]
    );

    return redirect()->back()->with('success', 'Collection record updated successfully!');
}

}
