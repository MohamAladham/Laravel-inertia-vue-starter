<?php

namespace Database\Seeders;

use App\Models\Role\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];

        foreach (
            [
                'admin'   => [ 'المديرون', 'fas fa-users' ],
                'user'    => [ 'المستخدمون', 'fas fa-users' ],
                'menu'    => [ 'القوائم', 'fas fa-bars' ],
                'setting' => [ 'الإعدادات', 'fas fa-cog' ],
                'country' => [ 'الدول والمدن', 'fas fa-globe-americas' ],
                'role'    => [ 'الأدوار والصلاحيات', 'fas fa-user-lock' ],
            ] as $k => $v )
        {

            if ( in_array( $k, [ 'menu', 'setting', 'country', 'role' ] ) )
            {
                $permissions[] = [
                    'name'     => "{$k}_manage",
                    'category' => $v[0],
                    'icon'     => $v[1],
                ];
                continue;
            }

            foreach ( [ 'show', 'update', 'delete' ] as $action )
            {
                $permissions[] = [
                    'name'     => "{$k}_{$action}",
                    'category' => $v[0],
                    'icon'     => $v[1],
                ];
            }
        }

        Permission::insert( $permissions );
    }
}
