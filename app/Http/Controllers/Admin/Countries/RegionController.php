<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\RegionRequest;
use App\Models\Country\Country;
use App\Models\Country\CountryRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RegionController extends Controller
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
    public function index( Country $country )
    {
        $data['country'] = $country;
        $data['items']   = $country->regions()->search()->withCount( 'cities' )->paginate( 100 );
        $data['title']   = 'المناطق';

        return Inertia::render( 'Admin/Countries/Regions/Index', $data );
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
     * @return \Illuminate\Http\Response
     */
    public function store( RegionRequest $request, Country $country )
    {
        $country->regions()->create( $request->validated() );

        return Redirect::back();
        //->with( 'success', 'تمت الإضافة بنجاح!' );
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
        $item = CountryRegion::findOrFail( $itemId );

        return response()->json( $item );
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update( Country $country, CountryRegion $region, RegionRequest $request )
    {
        $region->update( $request->validated() );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Country $country, CountryRegion $region )
    {
        $region->delete();

        return Redirect::back();
    }


    /*
     *
     */
    public function getRegionsJson( $countryId )
    {
        return response()->json( CountryRegion::where( 'country_id', $countryId )->get() );
    }


    /*
     *
     */
    public function order()
    {
        $items         = \request()->post( 'items' );
        $modelInstance = new CountryRegion;
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
