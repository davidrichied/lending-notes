<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Support\Facades\Request;

class LoanController extends Controller
{
    public function createLoan(Request $request)
    {
        return response()->json(Loan::create($request->toArray()));
    }

    public function loans()
    {
        dd(auth()->user());
    }
}
