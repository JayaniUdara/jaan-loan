<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'user_id',
        'customer_id',
        'amount_collected',
        'status',
        'notes',
        'collection_date',
        'approved_by',
        'is_approved',
    ];

    // Relationships
    public function collector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    
    
}

