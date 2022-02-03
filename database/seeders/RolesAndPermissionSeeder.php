<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
            // categories for boards
        Permission::create(['name'=>'see categories','guard_name'=>'api']);
        Permission::create(['name'=>'create categories','guard_name'=>'api']);
        Permission::create(['name'=>'updateAll categories','guard_name'=>'api']);
        Permission::create(['name'=>'update categories','guard_name'=>'api']);
        Permission::create(['name'=>'delete categories','guard_name'=>'api']);
            // permissions for boards
        Permission::create(['name'=>'see boards','guard_name'=>'api']);
        Permission::create(['name'=>'create boards','guard_name'=>'api']);
        Permission::create(['name'=>'updateAll boards','guard_name'=>'api']);
        Permission::create(['name'=>'update boards','guard_name'=>'api']);
        Permission::create(['name'=>'delete boards','guard_name'=>'api']);
            // permissions for columns
        Permission::create(['name'=>'see columns','guard_name'=>'api']);
        Permission::create(['name'=>'create columns','guard_name'=>'api']);
        Permission::create(['name'=>'updateAll columns','guard_name'=>'api']);
        Permission::create(['name'=>'update columns','guard_name'=>'api']);
        Permission::create(['name'=>'delete columns','guard_name'=>'api']);
            // permissions for cards
        Permission::create(['name'=>'see cards','guard_name'=>'api']);
        Permission::create(['name'=>'create cards','guard_name'=>'api']);
        Permission::create(['name'=>'updateAll cards','guard_name'=>'api']);
        Permission::create(['name'=>'update cards','guard_name'=>'api']);
        Permission::create(['name'=>'delete cards','guard_name'=>'api']);
            // permissions for tasks
        Permission::create(['name'=>'see tasks','guard_name'=>'api']);
        Permission::create(['name'=>'create tasks','guard_name'=>'api']);
        Permission::create(['name'=>'updateAll tasks','guard_name'=>'api']);
        Permission::create(['name'=>'update tasks','guard_name'=>'api']);
        Permission::create(['name'=>'delete tasks','guard_name'=>'api']);

        // create roles and assign to created permissions
            //Super admin role
        $role1=Role::create(['name'=>'super-admin','guard_name'=>'api']);
            //trial role 
        $role2=Role::create(['name'=>'trial','guard_name'=>'api'])
            ->givePermissionTo(Permission::all());
            //standart role
        $role3=Role::create(['name'=>'standart','guard_name'=>'api'])
            ->givePermissionTo(Permission::all());
            //timeout role
        $role4=Role::create(['name'=>'timeout','guard_name'=>'api'])
            ->givePermissionTo(
                [
                   'see categories',
                   'see boards',
                   'see columns',
                   'see cards',
                   'see tasks',
                ]                
            );
        // create demo users
        $user=User::factory()->create(
            [
                'name'=>'Bayram Yilmaz',
                'email'=>'bayramyilmaz61@gmail.com',
                'trial_until' => NULL,
                'password'=>Hash::make('12345678'),
            ]);
        $user->assignRole($role1);
        
        $user=User::factory()->create(
            [
                'name'=>'Bayram Keles',
                'email'=>'bayramkeles061@gmail.com',
                'trial_until' => NULL,
                'password'=>Hash::make('12345678'),
            ]);
        $user->assignRole($role1);

        $user=User::factory()->create(
            [
                'name'=>'trial',
                'email'=>'trial@gmail.com',
                'password'=>Hash::make('12345678')
            ]);
        $user->assignRole($role2);

        $user=User::factory()->create(
            [
                'name'=>'standart',
                'email'=>'standart@gmail.com',
                'password'=>Hash::make('12345678')
            ]);
        $user->assignRole($role3);

        $user=User::factory()->create(
            [
                'name'=>'timeout',
                'email'=>'timeout@gmail.com',
                'password'=>Hash::make('12345678')
            ]);
        $user->assignRole($role4);

        
    }
}
