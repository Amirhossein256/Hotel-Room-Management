<?php

namespace App\Observers;

use App\Models\Room;

class RoomObserver
{
    /**
     * Handle the Room "creating" event.
     *
     * @param  \App\Models\Room  $room
     * @return void
     */
    public function creating(Room $room)
    {

        $room->room_number = Room::generateRoomNumber();
    }
}
