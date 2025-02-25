<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Http\Resources\GuestResource;
use App\Models\Guest;
use Illuminate\Http\Request;
/**
 * @OA\Tag(
 *     name="Guests",
 *     description="Operations related to guests"
 * )
 */
class GuestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/guests",
     *     summary="Get the list of guests",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A list of guests",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Guest")
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

        $guests = Guest::query()
            ->latest()
            ->paginate($per_page);

        return GuestResource::collection($guests);
    }

    /**
     * @OA\Post(
     *     path="/api/guests",
     *     summary="Create a new guest",
     *     tags={"Guests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Guest created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function store(StoreGuestRequest $request)
    {
        $valid_data = $request->validated();

        $guest = Guest::create($valid_data);

        return new GuestResource($guest);
    }

    /**
     * @OA\Get(
     *     path="/api/guests/{id}",
     *     summary="Get a specific guest by ID",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Guest ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single guest",
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Guest not found"
     *     )
     * )
     */
    public function show(Guest $guest)
    {

        return new GuestResource($guest);
    }

    /**
     * @OA\Put(
     *     path="/api/guests/{id}",
     *     summary="Update a guest",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Guest ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Guest updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Guest")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Guest not found"
     *     )
     * )
     */
    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        $valid_data = $request->validated();

        $guest->update($valid_data);

        return new GuestResource($guest);
    }

    /**
     * @OA\Delete(
     *     path="/api/guests/{id}",
     *     summary="Delete a guest",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Guest ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Guest deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Guest not found"
     *     )
     * )
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return response()->noContent();
    }
}
