<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::insert([
            [
                'name'            => 'Mr. Admin',
                'email'           => 'admin@admin.com',
                'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id'         => 1,
                'remember_token'  => Str::random(10),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ],
            [
                'name'            => 'Mr. Editor',
                'email'           => 'editor@editor.com',
                'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id'         => 2,
                'remember_token'  => Str::random(10),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ],
            [
                'name'            => 'Mr. User',
                'email'           => 'user@user.com',
                'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id'         => 3,
                'remember_token'  => Str::random(10),
                'created_at'      => date("Y-m-d H:i:s"),
                'updated_at'      => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}

