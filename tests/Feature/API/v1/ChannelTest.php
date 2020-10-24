<?php

namespace tests\Feature\API\v1;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ChannelTest extends TestCase
{
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

    public function testGetAllChannelsList()
    {

        $response = $this->get(route('channel.all'));
        $response->assertStatus(200);
    }

    public function test_create_channel_should_be_validated()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_channel()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->postJson(route('channel.create'), [
            'name' => 'alexis'
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_channel_update_should_be_validated()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->json('PUT', route('channel.update'), []);
        $response->assertStatus(422);
    }

    public function test_channel_update()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create(['name' => 'mahshid']);
        $response = $this->json('PUT', route('channel.update'), [
            'id' => $channel->id,
            'name' => 'alexis'
        ]);
        $updatedChannel = Channel::find($channel->id);
        $this->assertEquals('alexis', $updatedChannel->name);
        $response->assertStatus(200);
    }

    public function test_channel_delete_should_be_validated()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->json('DELETE', route('channel.delete'), []);
        $response->assertStatus(422);
    }
}
