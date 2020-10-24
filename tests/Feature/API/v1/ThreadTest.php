<?php

namespace Tests\Feature\API\v1;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    public function test_all_threads_list_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_thread_should_be_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->get(route('threads.show', [$thread->slug]));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_thread_should_be_validated()
    {
        $response = $this->postJson(route('threads.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_can_create_thread()
    {
        $this->withExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson(route('threads.store'), [
            'title'=>'Foo',
            'content' => 'bar',
            'channel_id' => Channel::factory()->create()->id
        ]);
        $response->assertStatus(Response::HTTP_CREATED);

    }
}
