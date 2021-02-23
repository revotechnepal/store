<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'completed_by',
        'started_date',
        'completed_date',
        'description',
        'state',
        'price',
        'category_id'
    ];

    protected $casts = [
        'completed_by' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
