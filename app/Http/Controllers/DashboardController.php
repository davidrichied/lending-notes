<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $payments = $user->payments()
            ->whereNull('repaid_at')
            ->whereNull('payments.is_unpaid')
            ->orderBy('repay_at', 'asc')
            ->get()
            ->unique('loan_id');
        $loans = [];
        foreach ($payments as $payment) {
            $loans[] = [
                'loan' => $payment->loan->toArray(),
                'borrower' => $payment->loan->borrower->toArray(),
                'payments' => $payment->loan->payments()
                    ->whereNull('repaid_at')
                    ->whereNull('is_unpaid')
                    ->orderBy('repay_at', 'asc')
                    ->get()
                    ->toArray(),
            ];
        }
        return Inertia::render('Dashboard', [ 'loans' => $loans ]);
    }
}
