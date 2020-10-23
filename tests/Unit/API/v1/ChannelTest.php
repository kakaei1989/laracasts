<?php

namespace Unit\API\v1;

use App\Models\Channel;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function testGetAllChannelsList()
    {
        $response = $this->get(route('channel.all'));
        $response->assertStatus(200);
    }

    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'));
        $response->assertStatus(422);
    }

    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channel.create'), [
            'name' => 'alexis'
        ]);
        $response->assertStatus(201);
    }

    public function test_channel_update_should_be_validated()
    {
        $response = $this->json('PUT', route('channel.update'), []);
        $response->assertStatus(422);
    }

    public function test_channel_update()
    {
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
        $response = $this->json('DELETE', route('channel.delete'), []);
        $response->assertStatus(422);
    }
}
