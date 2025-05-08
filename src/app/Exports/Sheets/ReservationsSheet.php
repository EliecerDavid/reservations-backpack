<?php

namespace App\Exports\Sheets;

use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReservationsSheet implements FromView, WithTitle
{
    /**
     * @return View
     */
    public function view(): View
    {
        $reservations = Reservation::query()
            ->with('booker', 'room')
            ->orderBy('reservation_start', 'asc')
            ->get();

        return view('exports.reservations', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Reservations';
    }
}
