<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'm1aladham@gmail.com';

        $user = Admin::firstOrCreate(
            [ 'email' => $email ],
            [ 'password' => 'admin', 'email' => $email, 'name' => 'مدير النظام', ]
        );

        $user->roles()->attach( Role::first() );
    }
}
