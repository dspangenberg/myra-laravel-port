<?php

namespace Database\Seeders;

use App\Models\TimeCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TimeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeCategory::truncate();

        $time_categories = Storage::disk('json')->json('time_categories.json');
        foreach ($time_categories as $key => $value) {
            TimeCategory::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'pos' => $value['pos'] || 0,
                'short_name' => $value['short_name'],
                'is_default' => $value['is_default'],
                'hourly' => $value['hourly'],
            ]);
        }
    }
}
