<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dateofvisit',
        'phone',
        'email',
        'reason',
        'concerned_with',
        'assigned_to',
    ];
}