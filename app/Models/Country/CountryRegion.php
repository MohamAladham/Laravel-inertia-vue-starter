<?php

namespace App\Models\Country;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;

class CountryRegion extends Model
{

    protected $fillable = [ 'name' ];


    protected static function booted()
    {
        static::addGlobalScope( new OrderScope() );
    }

    public function country()
    {
        return $this->belongsTo( Country::class );
    }

    public function cities()
    {
        return $this->hasMany( CountryRegionCity::class, 'region_id' );
    }

    public function scopeSearch( $query )
    {
        if ( $q = request()->get( 'search' ) )
        {
            $query->where( 'name', 'like', "%{$q}%" );
        }
    }

}
