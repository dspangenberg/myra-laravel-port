<?php

namespace App\SushiModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

class ImportReceipt extends Model
{
    use Sushi;

    protected static string $file;

    public static function setVar(string $value)
    {
        self::$file = $value;

        return self::query();
    }

    public function getRows(): array
    {
        $jsonInvoices = Storage::disk('private')->json(self::$file);

        return collect($jsonInvoices)->toArray();
    }

    protected function sushiShouldCache()
    {
        return false;
    }
}
