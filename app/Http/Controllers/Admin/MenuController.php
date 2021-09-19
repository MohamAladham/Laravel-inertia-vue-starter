<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->middleware( "check_permission:menu_manage" );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['items'] = Menu::with( 'subMenus' )->parents()->get();
        $data['title'] = 'إعدادات القوائم';

        return Inertia::render( 'Admin/Menus/Index', $data );
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
    public function store( MenuRequest $request )
    {
        Menu::create( $request->validated() );

        return Redirect::route( 'admin.menus.index' )->with( 'success', 'تمت الإضافة بنجاح!' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit( Menu $menu )
    {
        return response()->json( $menu );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update( MenuRequest $request, Menu $menu )
    {
        $menu->update( $request->validated() );

        return Redirect::route( 'admin.menus.index' )->with( 'success', 'تم التعديل بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Menu $menu )
    {
        $menu->delete();

        return Redirect::route( 'admin.menus.index' )->with( 'success', 'تمت الحذف!' );
    }

    /*
     *
     */
    public function order()
    {
        // @todo: not working with sub menu
        $items         = \request()->post( 'items' );
        $modelInstance = new Menu;
        $updateArr     = [];
        $index         = 'id';
        $i             = 0;

        foreach ( $items as $k => $item )
        {
            $updateArr[] = [ 'id' => $item['id'], 'order' => $i++ ];

            foreach ( $item['sub_menus'] as $sub_menu )
            {
                $updateArr[] = [ 'id' => $sub_menu['id'], 'order' => $i++ ];
            }
        }

        \batch()->update( $modelInstance, $updateArr, $index );

        return Redirect::back();
    }
}
