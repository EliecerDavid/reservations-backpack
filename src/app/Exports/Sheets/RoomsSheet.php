<?php

namespace App\Exports\Sheets;

use App\Models\Room;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RoomsSheet implements FromView, WithTitle, WithStyles, ShouldAutoSize
{
    /**
     * @return View
     */
    public function view(): View
    {
        $rooms = Room::query()
            ->selectRaw('
                date(reservations.reservation_start) as date,
                rooms.name as room_name,
                count(*) as count
            ')
            ->join('reservations', 'rooms.id', 'reservations.room_id')
            ->where('reservations.status', 'accepted')
            ->groupByRaw('date(reservations.reservation_start), reservations.room_id')
            ->orderBy('date', 'asc')
            ->get();

        return view('exports.rooms', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rooms';
    }

    /**
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
