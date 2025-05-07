<?php

namespace App\Rules;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RoomAvailable implements ValidationRule
{
    protected ?Carbon $reservationStart = null;
    protected ?Carbon $reservationEnd = null;

    public function __construct(?Carbon $reservationStart)
    {
        if ($reservationStart) {
            $this->reservationStart = $reservationStart;
            $this->reservationEnd = (clone $reservationStart)->addHour();
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->reservationStart)) {
            return;
        }

        $room = Room::find($value);
        if (is_null($room)) {
            return;
        }

        if ($room->isAvailableInDateRange($this->reservationStart, $this->reservationEnd)) {
            return;
        }

        $fail('The :attribute is not available at ' . $this->reservationStart->format('m/d/Y, h:i A') . '.');
    }
}
