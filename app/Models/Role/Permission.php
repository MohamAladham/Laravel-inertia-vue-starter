<?php

namespace App\Models\Role;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = FALSE;
    protected $fillable = [ 'title' ];
    protected $appends = [ 'label' ];

    public function roles()
    {
        return $this->belongsToMany( Role::class, 'role_permission', 'permission_id', 'role_id' );
    }


    /*
     *
     */
    public function getLabelAttribute()
    {
        $action = explode( '_', $this->attributes['name'] ); //show, update, delete, management
        $action = end( $action );

        switch ( $action )
        {
            case 'show':
                return 'عرض';
            case 'update':
                return 'إضافة وتعديل';
            case 'delete':
                return 'حذف';
            case 'manage':
                return 'إدارة';
        }
    }


    /*
     *
     */
    public static function hasPermission( $admin, $permissions )
    {
        return Permission::where( 'name', '=', $permissions[0] )
            ->whereHas( 'roles', function ( Builder $query ) use ( $admin ) {
                $query->whereHas( 'admins', function ( Builder $users_query ) use ( $admin ) {
                    $users_query->where( 'admins.id', '=', $admin->id );
                } );
            } )->exists();
    }
}
