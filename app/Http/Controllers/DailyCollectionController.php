<?php

namespace App\Http\Controllers;

use App\Models\DailyCollection;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyCollectionController extends Controller
{
    public function index()
    {
        // Get today's date at start of day for comparison
        $today = Carbon::now()->startOfDay();
        
        // Fetch collections scheduled for today
        $collections = DailyCollection::with(['customer'])
            ->whereDate('collection_date', $today)
            ->get();
            
        
        return view('daily_collections.index', [
            'collections' => $collections
        ]);
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