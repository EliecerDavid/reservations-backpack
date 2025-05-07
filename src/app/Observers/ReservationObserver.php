<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservationObserver
{
    /**
     * Handle the Reservation "creating" event.
     */
    public function creating(Reservation $reservation): void
    {
        $reservation->reservation_end = (clone $reservation->reservation_start)->addHour();
        $reservation->booked_by = backpack_user()->id;
    }

    /**
     * Handle the Reservation "updating" event.
     */
    public function updating(Reservation $reservation): void
    {
        $reservation->reviewed_by = backpack_user()->id;
    }
}
