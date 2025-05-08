<?php

namespace App\Exports;

use App\Exports\Sheets\ReservationsSheet;
use App\Exports\Sheets\RoomsSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReservationsExport implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [
            new ReservationsSheet(),
            new RoomsSheet(),
        ];

        return $sheets;
    }
}
