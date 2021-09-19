<?php

namespace App\Http\Controllers\Admin\Countries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\CountryRequest;
use App\Models\Country\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Mavinoo\Batch\Batch;

class CountryController extends Controller
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
    public function index()
    {
        $data['items'] = Country::search()->withCount( 'regions' )
            ->paginate( 100 );

        $data['title'] = 'الدول';

        return Inertia::render( 'Admin/Countries/Index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( CountryRequest $request )
    {
        Country::create( $request->validated() );

        return Redirect::route( 'admin.countries.index' )->with( 'success', 'تمت الإضافة بنجاح!' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit( Country $country )
    {
        return response()->json( $country );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function update( CountryRequest $request, Country $country )
    {
        $country->update( $request->validated() );

        return Redirect::route( 'admin.countries.index' )->with( 'success', 'تم التعديل بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Country $country )
    {
        $country->delete();

        return Redirect::route( 'admin.countries.index' )->with( 'success', 'تمت الحذف!' );
    }

    /*
     *
     */
    public function order()
    {
        $items         = \request()->post( 'items' );
        $modelInstance = new Country;
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
