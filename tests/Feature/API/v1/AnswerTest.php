<?php

namespace Tests\Feature\API\v1;

use App\Models\Answer;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    public function test_can_get_all_answers_list()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(route('answers.index'));
        $response->assertSuccessful();
    }

    public function test_create_answer_should_be_validated()
    {
        $response = $this->postJson(route('answers.store'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'thread_id']);
    }

    public function test_can_submit_new_answer_for_thread()
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $thread = Thread::factory()->create();
        $response = $this->postJson(route('answers.store'), [
            'content' => 'Foo',
            'thread_id' => $thread->id
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message' => 'answer submitted succsessfully'
        ]);
        $this->assertTrue($thread->answers()->where('content', 'Foo')->exists());
    }

    public function test_update_answer_should_be_validated()
    {
        $answer = Answer::factory()->create();
        $response = $this->putJson(route('answers.update', [$answer]), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    public function test_can_update_own_answer_of_thread()
    {
        Sanctum::actingAs(User::factory()->create());
        $answer = Answer::factory()->create([
            'content' => 'Foo'
        ]);
        $response = $this->putJson(route('answers.update', [$answer]), [
            'content' => 'Bar',
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'answer updated succsessfully'
        ]);
        $answer->refresh();
        $this->assertEquals('Bar', $answer->content);
    }

    public function test_can_delete_own_answer()
    {
        $this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $answer = Answer::factory()->create();
        $response = $this->delete(route('answers.destroy', [$answer]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'answer deleted succsessfully'
        ]);
        $this->assertFalse(Thread::find($answer->thread_id)->answers()->whereContent($answer->content)->exists());
    }
}
