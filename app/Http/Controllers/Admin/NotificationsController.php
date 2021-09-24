<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class NotificationsController extends Controller
{


    public function __construct()
    {
    }


    public function index(): \Inertia\Response
    {
        $data['title']         = 'الإشعارات';
        $data['notifications'] = auth()->user()->notifications;

        return Inertia::render( 'Admin/Notifications', $data );
    }


    /*
     *
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return \redirect()->back();
    }


    /*
     *
     */
    public function markAsRead($id)
    {
        optional(auth()->user()->unreadNotifications->find($id))->markAsRead();

        return \redirect()->back();
    }
}
