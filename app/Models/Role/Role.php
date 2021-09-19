<?php

namespace App\Models\Role;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [ 'name' ];

    public function admins()
    {
        return $this->belongsToMany( Admin::class, 'admin_role', 'role_id', 'admin_id' );
    }

    public function permissions()
    {
        return $this->belongsToMany( Permission::class, 'role_permission', 'role_id', 'permission_id' );
    }
}
