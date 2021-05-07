<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        $user = new Admin();
        $user->password = Hash::make('admin');
        $user->email = 'admin@gmail.com';
        $user->name = 'مدير النظام';
        $user->save();
    }
}
