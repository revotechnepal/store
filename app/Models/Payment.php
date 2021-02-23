<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'date',
        'amount',
        'type',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
