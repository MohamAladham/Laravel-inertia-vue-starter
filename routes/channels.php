<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*
 * SAMPLE
Broadcast::channel( 'testbroadcasts.{id}', function ( $user ) {
    return TRUE;
}, [ 'guards' => [ 'admin' ] ] );*/


Broadcast::channel( 'App.Models.Admin.{id}', function ( $user, $id ) {
    return (int) $user->id === (int) $id;
}, [ 'guards' => [ 'admin' ] ] );
