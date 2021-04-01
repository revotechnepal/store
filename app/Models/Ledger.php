<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'particulars',
        'debit_amount',
        'credit_amount',
        'balance',
        'monthyear',
    ];
}
