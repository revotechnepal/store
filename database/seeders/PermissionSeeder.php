<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        RolePermission::insert([
            [
                'role_id' => '1',
                'permission_id' => '["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17"]',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
