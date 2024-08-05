<?php

namespace App\Exports;

use App\Models\BookkeepingBooking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Vitorccs\LaravelCsv\Concerns\Exportables\Exportable;

class BookingKeepingExport implements FromCollection
{
    use Exportable;

    public function collection(): Collection
    {
        return BookkeepingBooking::select('id')->get()->collect();
    }
}
