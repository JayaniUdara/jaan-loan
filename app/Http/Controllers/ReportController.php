<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Loan;
use App\Models\Customer;
use App\Models\DailyCollection;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get date range or set default (current month)
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Filtered Loans
        $totalLoans = Loan::whereBetween('created_at', [$startDate, $endDate])->count();

        // Filtered Customers
        $totalCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();

        // Filtered Outstanding Loan Amount
        $totalOutstandingLoans = Loan::whereBetween('created_at', [$startDate, $endDate])->sum('outstanding_balance');

        // Filtered Total Dues
        $totalDues = Loan::whereBetween('created_at', [$startDate, $endDate])->sum('total_due');

        // Filtered Total Collections
        $totalCollections = DailyCollection::whereBetween('collection_date', [$startDate, $endDate])
            ->where('status', 'collected')
            ->sum('amount_collected');

        return view('reports.index', compact(
            'totalLoans',
            'totalCustomers',
            'totalOutstandingLoans',
            'totalDues',
            'totalCollections'
        ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
