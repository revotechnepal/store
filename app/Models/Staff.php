<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'name',
        'email',
        'phone',
        'image',
        'national_id',
        'documents',
        'contract',
        'allocated_salary',
        'has_role',
        'status',
    ];

    public function position()
    {
        return $this->hasOne(Position::class, 'id' ,'position_id');
    }
}
