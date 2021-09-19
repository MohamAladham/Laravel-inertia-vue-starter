<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CityRequest;
use App\Http\Requests\Country\RegionRequest;
use App\Models\Country\Country;
use App\Models\Country\CountryRegion;
use App\Models\Country\CountryRegionCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RegionCityController extends Controller
{

    public function __construct()
    {
        $this->middleware( "check_permission:country_manage" );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Country $country, CountryRegion $region )
    {
        $data['country'] = $country;
        $data['region']  = $region;
        $data['items']   = $region->cities()->search()->paginate( 100 );
        $data['title']   = 'المدن';

        return Inertia::render( 'Admin/Countries/Cities/Index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @param \App\Models\CountryRegion $region
     * @return \Illuminate\Http\Response
     */
    public function store( CityRequest $request, Country $country, CountryRegion $region )
    {
        $region->cities()->create( $request->validated() );

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit( $itemId )
    {
        $item = CountryRegionCity::findOrFail( $itemId );

        return response()->json( $item );
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Country $country, CountryRegion $region, CountryRegionCity $city, CityRequest $request )
    {
        $city->update( $request->validated() );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Country $country, CountryRegion $region, CountryRegionCity $city )
    {
        $city->delete();

        return Redirect::back();
    }


    /*
     *
     */
    public function getCitiesJson( $regionId )
    {
        return response()->json( CountryRegionCity::where( 'region_id', $regionId )->get() );
    }


    /*
     *
     */
    public function order()
    {
        $items         = \request()->post( 'items' );
        $modelInstance = new CountryRegionCity;
        $updateArr     = [];
        $index         = 'id';

        foreach ( $items as $k => $item )
        {
            $updateArr[] = [ 'id' => $item['id'], 'order' => $k ];
        }

        \batch()->update( $modelInstance, $updateArr, $index );

        return Redirect::back();
    }
}
