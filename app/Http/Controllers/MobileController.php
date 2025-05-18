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
    {
        // Validate the request data
        $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount_collected' => 'required|numeric|min:0',
            'status' => 'required|in:collected,pending',
            'notes' => 'nullable|string',
        ]);
    
        //  pending collections
        $loan = Loan::with(['dailyCollections' => function($query) {
            $query->where('status', 'pending')
                  ->orderBy('collection_date', 'asc');
        }])->findOrFail($request->loan_id);
    
        $collectedAmount = $request->amount_collected;
        $remainingAmount = $collectedAmount;
    
        // Only process if there's a total_due and pending collections
        if ($loan->total_due > 0 && $loan->dailyCollections->isNotEmpty()) {
            foreach ($loan->dailyCollections as $collection) {
                if ($remainingAmount <= 0) break;
    
                $amountToApply = min($collection->amount_collected, $remainingAmount);
                
                $collection->update([
                    'added_amount' => $amountToApply,
                    'status' => $amountToApply >= $collection->amount_collected ? 'collected' : 'pending'
                ]);
    
                $remainingAmount -= $amountToApply;
            }
    
            // Update loan's total_due
            $loan->total_due = max(0, $loan->total_due - $collectedAmount + $remainingAmount);
            $loan->save();
    
            return redirect()->back()->with('success', 'Collection distributed to pending records successfully!');
        }
    
        // Default behavior if no pending records or no total_due
        $dailyCollection = DailyCollection::updateOrCreate(
            [
                'loan_id' => $loan->id,
                'collection_date' => Carbon::today()
            ],
            [
                'added_amount' => $request->amount_collected,
                'status' => $request->status,
                'notes' => $request->notes,
                'amount_collected' => $request->amount_collected,
                'user_id' => auth()->id()
            ]
        );
    
        return redirect()->back()->with('success', 'Collection record updated successfully!');
    }

}
