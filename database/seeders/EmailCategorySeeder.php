<?php

namespace Database\Seeders;

use App\Models\EmailCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class EmailCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      EmailCategory::truncate();

      $email_categories = Storage::disk('json')->json('email_categories.json');
      foreach ($email_categories as $key => $value) {
        EmailCategory::create([
          'id' => $value['id'],
          'name' => $value['name'],
          'type' => $value['type']
        ]);
      }
    }
}
