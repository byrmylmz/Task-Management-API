<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;


class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user);
        $response = $this->json('GET', '/api/permissions');

        $response->assertStatus(200);

    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_stores_new_users()
    {
        $response = $this->post('/register',[
            'name'=>'bayram',
            'email' => 'bayram1@gmail.com',
            'password' => '12345678', // password
            'password_confirmation' => '12345678', // password
           
        ]);

        



        

    }
}
