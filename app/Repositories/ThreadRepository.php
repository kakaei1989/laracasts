<?php

namespace App\Repositories;

use App\Models\Thread;

class ThreadRepository
{

    public function getAllAvailableThreads()
    {
        return Thread::where('flag', 1)->latest()->get();
    }

    public function getThreadBySlug($slug)
    {
        return Thread::where(['slug' => $slug, 'flag' => 1])->first();
    }
}
