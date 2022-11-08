<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'borrower_id',
        'loan_amount',
        'repayment_amount',
        'installments',
        'req_post',
        'req_post_title',
        'sent_at',
        'completed_at',
        'status',
        'notes',
        'is_late',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
