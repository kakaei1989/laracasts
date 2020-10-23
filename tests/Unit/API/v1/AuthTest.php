<?php

namespace Unit\API\v1;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
//    use RefreshDatabase;

    public function test_register_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name' => 'alexis',
            'email' => Str::random() . '@abc.com',
            'password' => '12345678',
        ]);
        $response->assertStatus(201);
    }

    public function test_login_should_be_validated()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(422);
    }

    public function test_user_can_login()
    {

        $response = $this->postJson(route('auth.login'), [
            'email' => 'kakaei1989@gmail.com',
            'password' => '12345678'
        ]);
        $response->assertStatus(200);
    }

    public function test_show_logged_in_user_info()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('auth.user'));
        $response->assertStatus(200);
    }

    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(200);
    }

}
