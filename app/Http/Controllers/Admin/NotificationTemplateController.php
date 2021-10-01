<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationTemplateRequest;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NotificationTemplateController extends Controller
{
    private string $viewPrefix = "Admin/NotificationTemplate/";
    private string $routePrefix = "admin.notification_template.";


    public function __construct()
    {
        $this->middleware( "check_permission:notification_template_manage" );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'قوالب الإشعارات';

        return Inertia::render( $this->viewPrefix . 'Index', $data );
    }


    /*
     *
     */
    public function fetchItems()
    {
        $data['items'] = NotificationTemplate::search()->paginate( 100 );

        return response()->json( [ 'items' => $data['items'] ] );
    }


    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit( $id )
    {
        $notification_template              = NotificationTemplate::findOrFail( $id );
        $notification_template->discription = nl2br( $notification_template->discription );

        $notification_template->description = nl2br( $notification_template->description );

        return response()->json( $notification_template );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NotificationTemplate $notification_template
     * @return \Illuminate\Http\Response
     */
    public function update( NotificationTemplateRequest $request, NotificationTemplate $notification_template )
    {
        $arr = $request->validated();
        $notification_template->update( $arr );

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( NotificationTemplate $notification_template )
    {
        $notification_template->delete();

        return Redirect::route( $this->routePrefix . 'index' )->with( 'success', 'تمت الحذف!' );
    }

}
