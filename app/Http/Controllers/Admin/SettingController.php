<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{

    public function general(): \Inertia\Response
    {
        $data['settings'] = Setting::pluck( 'value', 'key' );
        $data['title']    = 'الإعدادات العامة';

        return Inertia::render( 'Admin/Settings/General', $data );
    }


    /*
     *
     */
    public function updateGeneral()
    {
        $fields      = request()->except( [ '_token' ] );
        $filesFields = [ 'admin_panel_logo' ];

        foreach ( $fields as $k => $v )
        {
            if ( in_array( $k, $filesFields ) )
            {
                if ( $image = request()->file( $k ) )
                {
                    $v = Storage::disk( 'public' )->putFile( 'uploads/files', $image );
                    $v = url( Storage::url( $v ) );
                } elseif ( !@$fields[$k . 'Preview'] )
                {
                    $v = '';
                } else
                {
                    continue;
                }
            } elseif ( in_array( str_replace( 'Preview', '', $k ), $filesFields ) )
            {
                //ignore saving Preview fields
                continue;
            }


            Setting::updateOrCreate( [ 'key' => $k ], [ 'key' => $k, 'value' => $v ] );
        }

        Cache::forget( 'settings' );

        return redirect( route( 'admin.settings.general' ) )->with( 'success', 'تمت حفظ الإعدادات بنجاح!' );
    }
}
