<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
