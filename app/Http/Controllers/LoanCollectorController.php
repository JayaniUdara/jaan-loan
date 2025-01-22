<?php

namespace App\Http\Controllers;

use App\Models\LoanCollector;
use App\Models\DailyCollection;
use App\Models\Customer;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanCollectorController extends Controller
{
    // Display a list of loan collectors
    public function index()
    {


        $collectors = LoanCollector::with('user')->get();
        return view('collectors.index', compact('collectors'));
    }

    // Show details for a specific loan collector
    public function show($id)
    {
        $collector = LoanCollector::with('user')->findOrFail($id);
        return view('collectors.show', compact('collector'));
    }
   


    // Show the collections assigned to the loan collector for today
    public function dailyCollections()
    {
        $collector = LoanCollector::where('user_id', auth()->id())->firstOrFail();
        $collections = DailyCollection::where('collector_id', $collector->id)
            ->whereDate('collection_date', today())
            ->with('customer')
            ->with('loans')
            ->get();

        return view('daily_collections.index', compact('collections'));
    }

    // Mark a collection as completed
    public function markCollection(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:collected,missed',
            'notes' => 'nullable|string',
        ]);

        $collection = DailyCollection::findOrFail($id);
        $collection->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Collection status updated successfully.');
    }

    // Create a new loan collector
    public function create()
    {
        return view('collectors.create');
    }

    // Store a new loan collector
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assigned_date' => 'required|date',
        ]);

        LoanCollector::create([
            'user_id' => $request->user_id,
            'assigned_date' => $request->assigned_date,
        ]);

        return redirect()->route('collectors.index')->with('success', 'Loan collector created successfully.');
    }

        public function edit($id)
    {
        $collector = LoanCollector::findOrFail($id);
        return view('collectors.edit', compact('collector'));
    }
     
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assigned_date' => 'required|date',
        ]);

        $collector = LoanCollector::findOrFail($id);
        $collector->update([
            'user_id' => $request->user_id,
            'assigned_date' => $request->assigned_date,
        ]);

        return redirect()->route('collectors.index')->with('success', 'Loan collector updated successfully.');
    }

    public function destroy($id)
    {
        $collector = LoanCollector::findOrFail($id);
        $collector->delete();

        return redirect()->route('collectors.index')->with('success', 'Loan collector deleted successfully.');
    }
}
