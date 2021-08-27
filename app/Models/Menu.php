<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = FALSE;
    protected $fillable = [ 'title', 'url', 'is_active', 'order', 'parent_id' ];

    protected static function booted()
    {
        static::addGlobalScope( new OrderScope() );
    }

    public function subMenus()
    {
        return $this->hasMany( Menu::class, 'parent_id', 'id' );
    }

    public function scopeParents( $query )
    {
        $query->where( 'parent_id', '=', '0' );
    }
}
