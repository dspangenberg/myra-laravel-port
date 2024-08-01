<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\DocumentFolder;
use App\Models\TransactionRule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class ProcessDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-documents {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $importFile = $this->argument('file');

        /*
        $pdfBaseName = basename($importFile, '.pdf');
        $tmp = tempnam(sys_get_temp_dir(), $pdfBaseName).'_%d.pdf';

        Process::run('pdfseparate '.$importFile.' '.$tmp);

        $glob = str_replace('_%d', '*', $tmp);
        $pageDocuments = [];
        $fileCounter = 0;
        foreach (glob($glob, GLOB_NOSORT) as $filename) {
            echo "$filename size ".filesize($filename)."\n";
            $fileCounter++;
            preg_match('/_([0-9]{1,2})\.pdf/', $filename, $matches, PREG_OFFSET_CAPTURE);
            try {
                $result = Process::run('zbarimg '.$filename);
                if ($result->successful()) {
                    $outputArray = explode(':', $result->output());
                    if ($outputArray[0] === 'I2/5') {
                        $pageDocuments[] = [
                            'file' => $filename,
                            'code' => intval($outputArray[1]),
                            'page' => intval($matches[1][0]),
                        ];
                    } else {
                        var_dump($outputArray);
                    }
                }
            } catch (\Exception) {
            }
        }
        $collection = collect($pageDocuments);
        $collection->sortBy('page');

        Storage::disk('private')->put('documents2.json', json_encode($collection));
        dd($collection);
*/
        $documents = Storage::disk('private')->json('documents2.json');
        $pages = 28;

        $docs = collect($documents)->sortBy('page');
        $documentsWithRange = [];
        $range = [];
        for ($i = 1; $i <= $pages; $i++) {
            $doc = $docs->where('page', $i)->first();
            if ($doc) {
                if (count($range)) {
                    $doc['range'] = $range;
                    $documentsWithRange[] = $doc;
                }
                $range = [];
            }
            $range[] = $i;
        }

        $documentsWithRangeCollection = collect($documentsWithRange);
        $defaultDate = Carbon::parse(filemtime($importFile))->format('Y-m-d');
        $defaultFolder = DocumentFolder::where('is_default', 1)->first();
        $documentsWithRangeCollection->each(function ($doc) use ($defaultDate, $defaultFolder) {
            $colRange = collect($doc['range']);
            $firstPage = $colRange->min();
            $lastPage = $colRange->max();
            $numberOfPages = $lastPage - $firstPage + 1;
            $tmp = sys_get_temp_dir().'/Inbox-Scan-Label-ID-'.$doc['code'].'.pdf';

            $tmpPage = sys_get_temp_dir().'/Scan-20240730dan0Ug_%d.pdf';

            $pngFile = sys_get_temp_dir().'/Preview-Scan-Label-ID-'.$doc['code'];
            $pageFiles = [];
            $pngFiles = [];
            $pngResult = Process::run('pdftoppm -png -scale-to 600 '.$tmp.' '.$pngFile);
            if ($pngResult->successful()) {
                var_dump($pngResult->output());
            } else {
                var_dump($pngResult->errorOutput());
            }

            $counter = 0;
            for ($page = $firstPage; $page <= $lastPage; $page++) {
                $counter++;
                $pageFiles[] = str_replace('%d', $page, $tmpPage);
                $pngFiles[] = $pngFile.'-'.$counter.'.png';
                var_dump(str_replace('%d', $page, $tmpPage));
            }

            var_dump($pngFiles);

            $filesString = implode(' ', $pageFiles);
            $result = Process::run('pdfunite '.$filesString.' '.$tmp);
            if ($result->successful()) {
                $pfdToTextResult = Process::run('pdftotext '.$tmp);
                if ($pfdToTextResult->successful()) {
                    $textFile = str_replace('.pdf', '.txt', $tmp);
                    $text = file_get_contents($textFile);

                    $command = 'pdftotext -r 300 -f 1 -l 1 -x 200 -y 250 -W 1100 -H 550 '.$tmp;
                    $sender = '';
                    $pfdAdressParser = Process::run($command);
                    if ($pfdAdressParser->successful()) {
                        $textFile = str_replace('.pdf', '.txt', $tmp);
                        $addressField = file_get_contents($textFile);
                        preg_match('/((.+)[0-9][0-9][0-9][0-9][0-9]\D+)/', $addressField, $addressMatches);
                        $sender = $addressMatches[1];
                    } else {
                        dd($pfdAdressParser->errorOutput());
                    }

                    preg_match_all('/(0[1-9]|1[0-9]|2[0-9]|3[01])\.(0[1-9]|1[012])\.(?:19|20)[0-9]{2}/i', $text, $matches);
                    $dates = [];

                    if (count($matches)) {
                        foreach ($matches[0] as $key => $value) {
                            try {
                                $date = Carbon::createFromFormat('d.m.Y', $value);
                                if ($date < Carbon::now()) {
                                    $dates[] = $date->format('Y-m-d');
                                }
                            } catch (\Exception $e) {
                            }
                        }
                    } else {
                        $dates[] = $defaultDate;
                    }
                    $date = count($dates) ? $dates[0] : $defaultDate;
                    $dmsName = $date.'--'.basename($tmp);
                    $year = Carbon::parse($date)->format('Y');
                    $month = Carbon::parse($date)->format('m');

                    Storage::disk('s3')->put("/documents/inbox/$year/$month/$dmsName", file_get_contents($tmp));
                    var_dump($date, $dmsName, $numberOfPages);

                    $document = new Document;
                    $document->issued_on = $date;
                    $document->org_file = $dmsName;
                    $document->preview = basename($pngFile);
                    $document->fulltext = $text;
                    $document->sender = $sender;
                    $document->number_of_pages = $numberOfPages;
                    $document->size = filesize($tmp);
                    $document->document_folder_id = $defaultFolder->id;
                    $document->save();

                    $rules = TransactionRule::query()->where('table', 'documents')->get();
                    $rules->each(function ($rule) use ($document) {
                        $doc = Document::query()->where('id', $document->id)->where($rule->search_field, $rule->comparator, $rule->search_value)->first();
                        if ($doc) {
                            dump($doc->sender);
                            $document->setAttribute($rule->set_field, $rule->set_value);
                            $document->save();
                        }
                    });

                }
            } else {
                dd($result->errorOutput());
            }
        });

    }
}
