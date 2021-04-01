<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSales extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status',
    ];
}
