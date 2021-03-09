<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'mail_id',
        'file_name',
        'file_path',
    ];
}
