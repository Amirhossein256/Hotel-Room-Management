<?php

namespace App\Http\Controllers\API;

use App\Enums\RoomStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Reservations",
 *     description="Operations related to reservations"
 * )
 */
class ReservationController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/reservations",
     *     summary="Get a list of all reservations",
     *     tags={"Reservations"},
     *     @OA\Response(
     *         response=200,
     *         description="List of reservations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Reservation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index()
    {
        $reservations = Reservation::all();

        $reservationsData = ReservationResource::collection($reservations);

        return response()->json($reservationsData);
    }

    /**
     * @OA\Post(
     *     path="/api/reservations",
     *     summary="Create a new reservation",
     *     tags={"Reservations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"guest_id", "room_id", "check_in_date", "check_out_date"},
     *             @OA\Property(property="guest_id", type="integer", description="ID of the guest"),
     *             @OA\Property(property="room_id", type="integer", description="ID of the room"),
     *             @OA\Property(property="check_in_date", type="string", format="date", description="Check-in date"),
     *             @OA\Property(property="check_out_date", type="string", format="date", description="Check-out date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reservation created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Reservation created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=412,
     *         description="Precondition failed, room unavailable",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This Room Unavailable")
     *         )
     *     )
     * )
     */
    public function store(StoreReservationRequest $request)
    {
        $valid_data = $request->validated();

        $guest = Guest::findOrFail($valid_data['guest_id']);
        $room  = Room::findOrFail($valid_data['room_id']);

        if ($room->status != RoomStatusEnum::READY->value)
            return response()->json(['message' => 'This Room Unavailable'], 412);

        $guest->rooms()->attach($room, [
            'check_in_date'  => $valid_data['check_in_date'],
            'check_out_date' => $valid_data['check_out_date'],
        ]);
        $room->update(['status' => RoomStatusEnum::RESERVED]);

        return response()->json(['message' => 'Reservation created successfully']);
    }
}
