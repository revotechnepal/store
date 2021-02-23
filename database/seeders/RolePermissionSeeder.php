<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'permissions' => 'View Users'
            ],
            [
                'permissions' => 'Manage Users'
            ],
            [
                'permissions' => 'Manage Positions'
            ],
            [
                'permissions' => 'Manage Staffs'
            ],
            [
                'permissions' => 'Manage Staff Salary'
            ],
            [
                'permissions' => 'Staff Salary Report'
            ],
            [
                'permissions' => 'Manage Staff Attendance'
            ],
            [
                'permissions' => 'View Clients'
            ],
            [
                'permissions' => 'Manage Clients'
            ],
            [
                'permissions' => 'View Projects'
            ],
            [
                'permissions' => 'Manage Projects'
            ],
            [
                'permissions' => 'Manage Project Category'
            ],
            [
                'permissions' => 'Manage Third Party'
            ],
            [
                'permissions' => 'Manage Purchase Records'
            ],
            [
                'permissions' => 'Mange Visitors'
            ],
            [
                'permissions' => 'Manage Permissions'
            ],
            [
                'permissions' => 'Send Email'
            ],
        ]);
    }
}
