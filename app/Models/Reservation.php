<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Reservation",
 *     type="object",
 *     required={"guest_name", "room_number", "status", "check_in_date", "check_out_date"},
 *     @OA\Property(property="guest_name", type="string", description="Full name of the guest"),
 *     @OA\Property(property="room_number", type="string", description="Room number"),
 *     @OA\Property(property="status", type="string", enum={"ready", "pending_cleanup", "reserved"}, description="Room status"),
 *     @OA\Property(property="check_in_date", type="string", format="date", description="Check-in date"),
 *     @OA\Property(property="check_out_date", type="string", format="date", description="Check-out date")
 * )
 */
class Reservation extends Model
{
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in_date',
        'check_out_date'
    ];

    protected $table = 'room_guest_reservation';


    public function guest()
    {

        return $this->belongsTo(Guest::class);
    }

    public function room()
    {

        return $this->belongsTo(Room::class);
    }
}
