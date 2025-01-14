<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanCollector extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function collections()
    {
        return $this->hasMany(DailyCollection::class);
    }
}
