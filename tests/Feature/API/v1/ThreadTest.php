<?php

namespace Tests\Feature\API\v1;

use App\Models\Thread;
use Illuminate\Http\Response;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_all_threads_list_should_be_accessible()
    {
        $response = $this->get(route('threads.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function thread_should_be_accessible_by_slug()
    {
        $thread = Thread::factory()->create();
        $response = $this->get(route('threads.show',[$thread->slug]));
        $response->assertStatus(Response::HTTP_OK);
    }
}
