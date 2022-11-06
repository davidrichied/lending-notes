<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentsController extends Controller
{
    public function destroy(Request $request, Payment $payment)
    {
        $user = auth()->user();
        if ($payment->loan->user_id === $user->id) {
            $payment->delete();
        }
    }
}
