<?php

namespace Database\Seeders;

use App\Models\MailMessage;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::insert([
            ['name' => 'Admin', 'slug' => 'admin','created_at'=> date("Y-m-d H:i:s"),'updated_at'=> date("Y-m-d H:i:s")],
            ['name' => 'Editor','slug' => 'editor','created_at'=> date("Y-m-d H:i:s"),'updated_at'=> date("Y-m-d H:i:s")],
            ['name' => 'User',  'slug' => 'user','created_at'=> date("Y-m-d H:i:s"),'updated_at'=> date("Y-m-d H:i:s")],
        ]);
    }
}
