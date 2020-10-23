<?php

namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * @param $name
     */
    public function getAllChannelsList()
    {
        return Channel::all();
    }

    /**
     * @param $name
     */
    public function create($name): void
    {
        Channel::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);
    }

    /**
     * @param $name
     * @param $id
     */
    public function update($id, $name): void
    {
        Channel::find($id)->update([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    public function delete($id): void
    {
        Channel::destroy($id);
    }
}
