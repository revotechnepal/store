<?php

use App\Models\RolePermission;

if(!function_exists('checkpermission')) {
    function checkpermission($role_id, $permission_id)
    {
        $rolepermission = RolePermission::where('role_id', $role_id)->first();
        $permissions = $rolepermission->permission_id;
        if(in_array($permission_id, $permissions)) {
            $approved = 1;
        }
        else {
            $approved = 0;
        }
        return $approved;
    }
}
