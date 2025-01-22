<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_custom_id',
        'customer_id',
        'amount',
        'loan_approved_date',
        'loan_end_date',
        'outstanding_balance',
        'interest_rate',
        'installment_duration',
        'total_installments',
        'remaining_installments',
        'status',
        'total_due',
        'is_approved',
        'approved_by',
    ];


    /**
     * The relationships to always load by default.
     *
     * @var array
     */
    protected $with = ['customer', 'approvedBy', 'guarantors'];

    /**
     * Get the customer associated with the loan.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user who approved the loan.
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the guarantors for the loan.
     */
    public function guarantors()
    {
        return $this->hasMany(Guarantor::class);
    }

    public function dailyCollections()
    {
        return $this->hasMany(DailyCollection::class);
    }

    
}
