<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'thirdparty_name',
        'purchase_date',
        'bill_number',
        'bill_amount',
        'paid_amount',
        'purpose',
        'monthyear',
    ];
}
