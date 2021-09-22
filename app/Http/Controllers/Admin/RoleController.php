<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role\Permission;
use App\Models\Role\Role;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use mysql_xdevapi\Exception;
use function PHPUnit\Framework\throwException;

class RoleController extends Controller
{
    private string $viewPrefix = "Admin/Roles/";
    private string $routePrefix = "admin.roles.";


    public function __construct()
    {
        $this->middleware( "check_permission:role_manage" );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'الأدوار والصلاحيات';

        return Inertia::render( $this->viewPrefix . 'Index', $data );
    }


    /*
     *
     */
    public function fetchItems()
    {
        $data['items'] = Role::search()->latest()->paginate( 100 );

        return response()->json( [ 'items' => $data['items'] ] );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['permissions'] = Permission::get()->groupBy( 'category' );
        $data['title']       = 'إضافة دور جديد';

        return Inertia::render( $this->viewPrefix . 'Form', $data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( RoleRequest $request )
    {
        $arr  = $request->validated();
        $role = Role::create( $arr );
        $role->permissions()->attach( $request->permissions );

        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit( $id )
    {
        $role                     = Role::findOrFail( $id );
        $data['role_permissions'] = $role->permissions->pluck( 'id' );
        $data['title']            = $role->name;
        $data['item']             = $role;
        $data['permissions']      = Permission::get()->groupBy( 'category' );

        return Inertia::render( $this->viewPrefix . 'Form', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update( RoleRequest $request, Role $role )
    {
        $arr = $request->validated();
        $role->update( $arr );
        $role->permissions()->sync( $request->permissions );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Role $role )
    {
        $role->delete();

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تمت الحذف!' );
    }

}
