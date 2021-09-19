<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Role\Role;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    private string $viewPrefix = "Admin/Admins/";
    private string $routePrefix = "admin.admins.";

    public function __construct()
    {
        $this->middleware( "check_permission:admin_show", [ 'only' => [ 'index', 'export' , 'edit'] ] );
        $this->middleware( "check_permission:admin_update", [ 'only' => [ 'create', 'store', 'update' ] ] );
        $this->middleware( "check_permission:admin_delete", [ 'only' => [ 'destroy' ] ] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['items'] = Admin::with( 'roles' )->search()
            ->paginate( 20 );

        $data['title'] = 'المديرون';

        return Inertia::render( $this->viewPrefix . 'Index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'إضافة مدير جديد';

        return Inertia::render( $this->viewPrefix . 'Form', $data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( AdminRequest $request )
    {
        $arr = $request->validated();
        if ( $image = request()->file( 'photo' ) )
        {
            $arr['photo'] = Storage::disk( 'public' )->putFile( 'uploads/admins', $image );
        }

        $admin = Admin::create( $arr );
        $admin->roles()->sync( $request->roles );

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تمت الإضافة بنجاح!' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit( $id )
    {
        $admin               = Admin::findOrFail( $id );
        $data['title']       = $admin->name;
        $data['item']        = $admin;
        $data['admin_roles'] = $admin->roles->pluck( 'id' );
        $data['roles']       = Role::get();

        return Inertia::render( $this->viewPrefix . 'Form', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update( AdminRequest $request, Admin $admin )
    {
        $arr = $request->validated();

        if ( !$arr['password'] )
        {
            unset( $arr['password'] );
        }

        if ( $image = request()->file( 'photo' ) )
        {
            $arr['photo'] = Storage::disk( 'public' )->putFile( 'uploads/admins', $image );
        } elseif ( !$arr['photoPreview'] )
        {
            $arr['photo'] = NULL;
        } else
        {
            unset( $arr['photo'] );
        }

        $admin->roles()->sync( $request->roles );
        $admin->update( $arr );

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تم التعديل بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Admin $admin )
    {
        $admin->delete();

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تمت الحذف!' );
    }

    /*
     *
     */
    public function export()
    {
        return Excel::download( new AdminsExport, 'admins_' . time() . '.xlsx' );
    }
}
