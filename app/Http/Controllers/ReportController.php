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
    public function index()
    {
        // Total number of loans
        $totalLoans = Loan::count();

        // Total number of customers
        $totalCustomers = Customer::count();

        // Total outstanding loan amount
        $totalOutstandingLoans = Loan::sum('outstanding_balance');

        // Total dues
        $totalDues = Loan::sum('total_due');

        // Total daily collections
        $totalCollections = DailyCollection::where('status', 'collected')->sum('amount_collected');

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
