<?php

namespace App\Models;

use App\Models\Country\Country;
use App\Models\Country\CountryRegion;
use App\Models\Country\CountryRegionCity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'user';

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


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /*
     *
     */
    public function country()
    {
        return $this->belongsTo( Country::class );
    }

    /*
     *
     */
    public function region()
    {
        return $this->belongsTo( CountryRegion::class );
    }


    /*
     *
     */
    public function city()
    {
        return $this->belongsTo( CountryRegionCity::class );
    }


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
