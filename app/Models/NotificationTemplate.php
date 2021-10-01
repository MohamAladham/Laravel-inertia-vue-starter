<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    public $timestamps = FALSE;
    protected $fillable = [ 'key', 'name', 'email_subject', 'email_text', 'sms_text', 'notification_text', 'description' ];


    /*
     *
     */
    public function scopeSearch( $query )
    {
        if ( $q = request()->get( 'search' ) )
        {
            $query->where( function ( $sub ) use ( $q ) {
                $sub->where( 'name', 'like', "%{$q}%" );
            } );
        }
    }

}
