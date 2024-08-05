<?php

namespace App\Console\Commands;

use App\Models\Contact;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Spatie\TemporaryDirectory\Exceptions\PathAlreadyExists;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class ExportCreditors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-creditors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @throws PathAlreadyExists
     */
    #[NoReturn]
    public function handle(): void
    {

        $contacts = Contact::where('is_creditor', true)->whereNull('creditor_number')->get();

        $temporaryDirectory = (new TemporaryDirectory)
            ->create();

        $tmpFile = $temporaryDirectory->path(Str::random().'.csv');

        $handle = fopen($tmpFile, 'w');
        fputcsv($handle, ['Name', 'VatId', 'Erfolgskonto']);

        foreach ($contacts as $contact) {
            fputcsv($handle, [
                $contact->full_name,
                $contact->vat_id,
                $contact->outturn_account_id,
            ]);
        }

        fclose($handle);
        dd($tmpFile);
    }
}
