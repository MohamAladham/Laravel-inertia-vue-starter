<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [ 'photo' ];

    /*
     *
     */
    public function scopeSearch( $query )
    {
        if ( $q = request()->get( 'search' ) )
        {
            $query->where( function ( $sub ) use ( $q ) {
                $sub->where( 'name', 'like', "%{$q}%" )
                    ->orWhere( 'email', 'like', "%{$q}%" );
            } );
        }
    }

    /*
     *
     */
    public function setPasswordAttribute( $value )
    {
        $this->attributes['password'] = bcrypt( $value );
    }

    public function getPhotoAttribute()
    {
        return $this->attributes['photo'] ? url( Storage::url( $this->attributes['photo'] ) ) : asset( 'assets/admin/custom/img/avatar.png' );
    }

}
