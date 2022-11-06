<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoansController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        // Create Borrower
        $borrowerData = $request->borrower;
        $borrower = User::where('email', $borrowerData['email'])->first();
        if (empty($borrower)) {
            $borrower = User::create($borrowerData);
        }
        // Create Loan
        $loanData = $request->loan;
        $loan = Loan::create($loanData);
        $loan->update([
            'borrower_id' => $borrower->id,
            'user_id' => $user->id,
        ]);
        // Create payments
        $payments = $request->payments;
        foreach ($payments as $payment) {
            $loan->payments()->create($payment);
        }
        return Redirect::route('dashboard');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $borrowerData = $request->borrower;
        $borrower = User::find($borrowerData['id']);
        $borrower->update($borrowerData);
        $loanData = $request->loan;
        $loan = Loan::find($loanData['id']);
        $loan->update($loanData);
        $paymentsData = $request->payments;
        // create/update payments
        foreach ($paymentsData as $paymentData) {
            if (!empty($paymentData['id'])) {
                $payment = Payment::find($paymentData['id']);
                $payment->update($paymentData);
            } else {
                $loan->payments()->create($paymentData);
            }
        }
    }

    public function loans()
    {
        dd(auth()->user());
    }
}
