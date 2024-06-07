<?php

namespace Database\Seeders;

use App\Models\PhoneCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PhoneCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhoneCategory::truncate();

        $categories = Storage::disk('json')->json('phone_categories.json');
        foreach ($categories as $key => $value) {
            PhoneCategory::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'type' => $value['type'],
            ]);
        }
    }
}
