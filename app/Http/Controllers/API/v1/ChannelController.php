<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChannelController extends Controller
{
    public function getAllChannels()
    {
        $allChannels = resolve(ChannelRepository::class)->getAllChannelsList();
        return response()->json($allChannels, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        resolve(ChannelRepository::class)->create($request->name);
        return response()->json(['message' => 'new channel created'], 201);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);
        resolve(ChannelRepository::class)->update($request->id, $request->name);

        return response()->json([
            'message' => 'channel created successfully'
        ], Response::HTTP_OK);
    }

    /**
     * delete channel(s )
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteChannel(Request $request)
    {
        $request->validate([
            'id' => ['required']
        ]);
        resolve(ChannelRepository::class)->delete($request->id);

        return response()->json([
            'message' => 'channel deleted successfully'
        ],Response::HTTP_OK);
    }
}
