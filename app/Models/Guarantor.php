<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_id',
        'name',
        'contact',
        'address',
        'national_id',
        'relationship',
        'date_of_birth',
        'occupation',
        'annual_income',
        'additional_notes',
    ];

    /**
     * Get the loan associated with the guarantor.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
