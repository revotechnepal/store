<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'categories',
        'unit_price',
        'stock',
        'info',
        'image',
        'description',
    ];

    protected $casts = [
        'categories' => 'array'
    ];

}
