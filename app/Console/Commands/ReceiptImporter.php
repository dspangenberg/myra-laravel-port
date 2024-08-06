<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\select;

class ReceiptImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:receipt-importer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = [];
        foreach (glob(database_path('/private-data/*.json')) as $filename) {
            $files[] = basename($filename);
        }

        $filename = select(
            label: 'Datei mit Belegdaten auswählen:',
            options: $files,
            scroll: 10
        );

        $json = Storage::disk('private')->json($filename);
        $collection = collect($json);

        $collection->each(function ($item) {
            $orgReceipt = collect($item)->dot();
            print_r($orgReceipt);
        });

    }
}
