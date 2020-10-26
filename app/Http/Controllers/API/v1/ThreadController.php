<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = resolve(ThreadRepository::class)->getAllAvailableThreads();
        return \response()->json($threads, Response::HTTP_OK);
    }

    public function show($slug)
    {
        $thread = resolve(ThreadRepository::class)->getThreadBySlug($slug);
        return \response()->json($thread, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'channel_id' => 'required',
        ]);
        resolve(ThreadRepository::class)->store($request);
        return \response()->json([
            'message' => 'thread created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Thread $thread)
    {
        if (!$request->has('best_answer_id')) {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'channel_id' => 'required',
            ]);
        } else {
            $request->validate([
                'best_answer_id' => 'required'
            ]);
        }
        if (Gate::forUser(auth()->user())->allows('manage-thread', $thread)) {
            resolve(ThreadRepository::class)->update($request, $thread);
            return \response()->json([
                'message' => 'thread updated successfully'
            ], Response::HTTP_OK);
        } else {
            return \response()->json([
                'message' => 'access denied'
            ], Response::HTTP_FORBIDDEN);
        }
    }

    public function destroy(Thread $thread)
    {
        if (Gate::forUser(auth()->user())->allows('manage-thread', $thread)) {
            resolve(ThreadRepository::class)->destroy($thread);
            return \response()->json([
                'message' => 'thread updated successfully'
            ], Response::HTTP_OK);
        } else {
            return \response()->json([
                'message' => 'access denied'
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
