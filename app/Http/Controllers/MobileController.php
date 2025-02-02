<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use App\Models\DailyCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;


class MobileController extends Controller
{
    public function index()
    {
        // Get today's date at start of day for comparison
        $today = Carbon::now()->startOfDay();
        
        $collections = DailyCollection::with(['customer'])
            ->whereDate('collection_date', $today)
            ->get();
            
        
        return view('mobile.index', [   
            'collections' => $collections
        ]);
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
