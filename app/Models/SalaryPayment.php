<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'payment_date',
        'amount',
        'salary_type',
        'monthyear'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
