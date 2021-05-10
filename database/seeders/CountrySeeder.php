<?php

namespace Database\Seeders;

use App\Models\Country\Country;
use App\Models\Country\CountryRegion;
use App\Models\Country\CountryRegionCity;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pal = Country::create( [ 'name' => 'فلسطين' ] );
        $sa  = Country::create( [ 'name' => 'المملكة العربية السعودية' ] );

        $pal_reg_1 = CountryRegion::create( [ 'name' => 'قطاع غزة', 'country_id' => $pal->id ] );
        $pal_reg_2 = CountryRegion::create( [ 'name' => 'الضفة الغربية', 'country_id' => $pal->id ] );
        $sa_reg_1  = CountryRegion::create( [ 'name' => 'منطقة الرياض', 'country_id' => $sa->id ] );
        $sa_reg_2  = CountryRegion::create( [ 'name' => 'منطقة مكة', 'country_id' => $sa->id ] );

        CountryRegionCity::insert( [
            [ 'name' => 'جباليا', 'region_id' => $pal_reg_1->id ],
            [ 'name' => 'رفح', 'region_id' => $pal_reg_1->id ],
            [ 'name' => 'طول كرم', 'region_id' => $pal_reg_2->id ],
            [ 'name' => 'رام الله', 'region_id' => $pal_reg_2->id ],
            [ 'name' => 'مدينة الرياض', 'region_id' => $sa_reg_1->id ],
            [ 'name' => 'مدينة الرياض 2', 'region_id' => $sa_reg_1->id ],
            [ 'name' => 'مكة المكرمة', 'region_id' => $sa_reg_2->id ],
            [ 'name' => 'مكة المكرمة 2', 'region_id' => $sa_reg_2->id ],
        ] );
    }
}
