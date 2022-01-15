<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $users=[
        [
            'name'=>'Bayram Yilmaz',
            'email'=>'bayramyilmaz061@gmail.com',
            'password'=>Hash::make('12345678'),
            'created_at'=>now(),
            'updated_at'=>now(),
        ],
        [
            'name'=>'Bayram Keles',
            'email'=>'bayramkeles61@gmail.com',
            'password'=>Hash::make('12345678'),
            'created_at'=>now(),
            'updated_at'=>now(),
        ],
            ];

            
        foreach($users as $user){
            User::create($user);
            }
    }
}
