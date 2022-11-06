<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'repay_at',
        'repaid_at',
        'is_unpaid',
        'is_late',
        'loan_id',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
