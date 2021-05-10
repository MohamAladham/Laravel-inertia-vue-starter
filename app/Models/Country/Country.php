<?php

namespace App\Models\Country;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{


    protected $fillable = [ 'name' ];

    protected static function booted()
    {
        static::addGlobalScope( new OrderScope() );
    }

    public function regions()
    {
        return $this->hasMany( CountryRegion::class );
    }

    public function scopeSearch( $query )
    {
        if ( $q = request()->get( 'search' ) )
        {
            $query->where( 'name', 'like', "%{$q}%" );
        }
    }

}
