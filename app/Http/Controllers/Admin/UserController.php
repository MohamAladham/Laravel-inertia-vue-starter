<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    private string $viewPrefix = "Admin/Users/";
    private string $routePrefix = "admin.users.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['items'] = User::search()
            ->paginate( 20 );

        $data['title'] = 'المستخدمون';

        return Inertia::render( $this->viewPrefix . 'Index', $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'إضافة مستخدم جديد';

        return Inertia::render( $this->viewPrefix . 'Form', $data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( UserRequest $request )
    {
        $arr = $request->validated();
        if ( $image = request()->file( 'photo' ) )
        {
            $arr['photo'] = Storage::disk( 'public' )->putFile( 'uploads/users', $image );
        }

        User::create( $arr );

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تمت الإضافة بنجاح!' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit( User $user )
    {
        $data['title'] = $user->name;
        $data['item']  = $user;

        return Inertia::render( $this->viewPrefix . 'Form', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update( UserRequest $request, User $user )
    {
        $arr = $request->validated();

        if ( !$arr['password'] )
        {
            unset( $arr['password'] );
        }

        if ( $image = request()->file( 'photo' ) )
        {
            $arr['photo'] = Storage::disk( 'public' )->putFile( 'uploads/users', $image );
        } elseif ( !$arr['photoPreview'] )
        {
            $arr['photo'] = NULL;
        } else
        {
            unset( $arr['photo'] );
        }

        $user->update( $arr );

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تم التعديل بنجاح' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( User $user )
    {
        $user->delete();

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تمت الحذف!' );
    }

    /*
     *
     */
    public function export()
    {
        return Excel::download( new UsersExport, 'users_' . time() . '.xlsx' );
    }
}
