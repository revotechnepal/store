<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $casts = [
        'permission_id' => 'array',
    ];
    protected $fillable = ['role_id', 'permission_id'];

    public function getrolename()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function getpermissions()
    {
        return $this->hasMany(Permission::class, 'id', 'permission_id');
    }
}
