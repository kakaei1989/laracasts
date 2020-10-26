<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Thread;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = resolve(AnswerRepository::class)->getAllAnswers();
        return response()->json($answers, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'thread_id' => 'required',
        ]);
        resolve(AnswerRepository::class)->store($request);
        return \response()->json([
            'message' => 'answer submitted succsessfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Answer $answer)
    {
        $request->validate([
            'content' => 'required',
        ]);
        resolve(AnswerRepository::class)->update($request, $answer);
        return \response()->json([
            'message' => 'answer updated succsessfully'
        ], Response::HTTP_OK);
    }

    public function destroy(Answer $answer)
    {
        resolve(AnswerRepository::class)->destroy($answer);
        return \response()->json(['message' => 'answer deleted succsessfully'], Response::HTTP_OK);
    }
}
