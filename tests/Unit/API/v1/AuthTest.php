<?php

namespace Unit\API\v1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function registerRolesAndPermissions()
    {
        $roleInDatabase = Role::where('name', Config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (Config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabase = Permission::where('name', Config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (Config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

    public function test_register_should_be_validate()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(422);
    }

    public function test_new_user_can_register()
    {
        $this->registerRolesAndPermissions();
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
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
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
