<?php

namespace Database\Seeders;

use App\Models\Country\Country;
use App\Models\Country\CountryRegion;
use App\Models\Country\CountryRegionCity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user           = new User();
        $user->password = Hash::make( '123123123' );
        $user->email    = 'm1aladham@gmail.com';
        $user->name     = 'محمد الأدهم';
        $user->country()->associate( Country::find( 1 ) );
        $user->region()->associate( CountryRegion::find( 1 ) );
        $user->city()->associate( CountryRegionCity::find( 1 ) );
        $user->save();
    }
}
