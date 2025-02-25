<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Room",
 *     type="object",
 *     required={"status"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Room ID"
 *     ),
 *     @OA\Property(
 *         property="room_number",
 *         type="integer",
 *         description="Room number"
 *     ),
 *     @OA\Property(
 *         property="room_name",
 *         type="string",
 *         description="Room number"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"ready", "pending_cleanup", "reserved"},
 *         description="Room status"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the room was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the room was last updated"
 *     )
 * )
 */
class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'room_number',
        'status',
        'room_name'
    ];

    public static function generateRoomNumber(): string
    {

        $room_number = rand(100000, 999999);
        if (self::where('room_number', $room_number)->exists()) {

            self::generateRoomNumber();
        }

        return $room_number;

    }}
