<?php

namespace App\Console\Commands;

use App\Models\BookkeepingBooking;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Spatie\TemporaryDirectory\Exceptions\PathAlreadyExists;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class ExportBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @throws PathAlreadyExists
     */
    #[NoReturn]
    public function handle(): void
    {
        $bookings = BookkeepingBooking::with('range_document_number')->whereBetween('date', ['2021-01-01', '2021-01-31'])->orderBy('date')->get();
        $temporaryDirectory = (new TemporaryDirectory)
            ->create();

        $tmpFile = $temporaryDirectory->path(Str::random().'.csv');

        $handle = fopen($tmpFile, 'w');
        fputcsv($handle, ['Belegdatum', 'SollKonto', 'HabenKonto', 'Buchungstext', 'Betrag', 'Beleg']); // Add more headers as needed

        foreach ($bookings as $booking) {
            fputcsv($handle, [
                $booking->date->format('d.m.Y'),
                $booking->account_id_credit,
                $booking->account_id_debit,
                trim($booking->booking_text, '|'),
                number_format($booking->amount, 2, ',', ''),
                $booking->document_number,
            ]);
        }

        fclose($handle);
        dd($tmpFile);
    }
}
