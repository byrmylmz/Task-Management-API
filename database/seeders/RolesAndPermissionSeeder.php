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
        Permission::create(['name'=>'see categories']);
        Permission::create(['name'=>'create categories']);
        Permission::create(['name'=>'updateAll categories']);
        Permission::create(['name'=>'update categories']);
        Permission::create(['name'=>'delete categories']);
            // permissions for boards
        Permission::create(['name'=>'see boards']);
        Permission::create(['name'=>'create boards']);
        Permission::create(['name'=>'updateAll boards']);
        Permission::create(['name'=>'update boards']);
        Permission::create(['name'=>'delete boards']);
            // permissions for columns
        Permission::create(['name'=>'see columns']);
        Permission::create(['name'=>'create columns']);
        Permission::create(['name'=>'updateAll columns']);
        Permission::create(['name'=>'update columns']);
        Permission::create(['name'=>'delete columns']);
            // permissions for cards
        Permission::create(['name'=>'see cards']);
        Permission::create(['name'=>'create cards']);
        Permission::create(['name'=>'updateAll cards']);
        Permission::create(['name'=>'update cards']);
        Permission::create(['name'=>'delete cards']);
            // permissions for tasks
        Permission::create(['name'=>'see tasks']);
        Permission::create(['name'=>'create tasks']);
        Permission::create(['name'=>'updateAll tasks']);
        Permission::create(['name'=>'update tasks']);
        Permission::create(['name'=>'delete tasks']);

        // create roles and assign to created permissions
            //Super admin role
        $role1=Role::create(['name'=>'super-admin']);
            //trial role 
        $role2=Role::create(['name'=>'trial'])
            ->givePermissionTo(Permission::all());
            //standart role
        $role3=Role::create(['name'=>'standart'])
            ->givePermissionTo(Permission::all());
            //timeout role
        $role4=Role::create(['name'=>'timeout'])
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
                'email'=>'bayramyilmaz061@gmail.com',
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
