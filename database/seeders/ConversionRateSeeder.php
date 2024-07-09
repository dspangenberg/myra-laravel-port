<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ConversionRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class ConversionRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $y = 2022;
        $rates = Storage::disk('private')->json('kurse-2022.json');
        $year = collect($rates)->get($y);
        if ($year) {
            $rates = collect($year)->get('USD');
        }
        for ($index = 1; $index < 13; $index++) {

            ConversionRate::create([
                'currency_code' => 'USD',
                'year' => $y,
                'month' => $index,
                'rate'  => $rates[$index],
            ]);

            dump($rates[$index]);
        }






    }
}
