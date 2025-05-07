<?php

namespace App\Observers;

use App\Models\Room;

class RoomObserver
{
    /**
     * Handle the Room "creating" event.
     */
    public function creating(Room $room): void
    {
        $room->created_by = backpack_user()->id;
    }
}
