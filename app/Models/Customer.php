<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'email',
        'address',
        'date_of_birth',
        'national_id',
        'occupation',
        'monthly_income',
        'profile_photo_path',
        'is_approved',
        'approved_by',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationships
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
