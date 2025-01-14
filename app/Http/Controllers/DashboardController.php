<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\DailyCollection;
use App\Models\Payment;

use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check role and return the corresponding dashboard view
        switch ($user->role) {
            case 'loan_handler':
                $totalLoans = Loan::count();
                $outstandingBalances = Loan::where('status', 'active')->sum('outstanding_balance');
                $totalPaid = Payment::sum('amount');

                return view('dashboard.manager', compact('totalLoans', 'outstandingBalances', 'totalPaid'));

            case 'data_entry':
                return view('dashboard.data_entry');

            case 'loan_collector':
                $collections = DailyCollection::where('user_id', $user->id)
                    ->where('collection_date', today())
                    ->get();

                return view('dashboard.collector', compact('collections'));

            default:
                abort(403, 'Unauthorized action.');
        }
    }


    public function reports()
    {
        // Reports generation logic
        return view('reports.index');
    }
}
