<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Rooms",
 *     description="Operations related to rooms"
 * )
 */
class RoomController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rooms",
     *     summary="Get the list of rooms",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of rooms",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Room")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid parameters"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $per_page = $request->get('per_page', 15);

        $rooms = Room::paginate($per_page);

        return RoomResource::collection($rooms);
    }

    /**
     * @OA\Post(
     *     path="/api/rooms",
     *     summary="Create a new room",
     *     tags={"Rooms"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Room created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function store(StoreRoomRequest $request)
    {
        $valid_data = $request->validated();

        $room = Room::create($valid_data);

        return new RoomResource($room);
    }

    /**
     * @OA\Get(
     *     path="/api/rooms/{id}",
     *     summary="Get a specific room by ID",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Room ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single room",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function show(Room $room)
    {

        return new RoomResource($room);
    }

    /**
     * @OA\Put(
     *     path="/api/rooms/{id}",
     *     summary="Update a room",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Room ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Room updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Room")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $valid_data = $request->validated();

        $room->update($valid_data);

        return new RoomResource($room);
    }

    /**
     * @OA\Delete(
     *     path="/api/rooms/{id}",
     *     summary="Delete a room",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Room ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Room deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found"
     *     )
     * )
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->noContent();
    }
}
