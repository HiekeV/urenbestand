<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'financial_year',
        'week',
        'date',
        'employee_number',
        'hours',
        'hour_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
