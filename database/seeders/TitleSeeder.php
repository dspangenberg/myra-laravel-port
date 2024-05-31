<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Title::truncate();

    $titles = Storage::disk('json')->json('titles.json');
    foreach ($titles as $key => $value) {
      Title::create([
        'id' => $value['id'],
        'name' => $value['name'],
        'correspondence_salutation_male' => $value['correspondence_salutation_male'],
        'correspondence_salutation_female' => $value['correspondence_salutation_female'],
        'correspondence_salutation_other' => $value['correspondence_salutation_other']
      ]);
    }
  }
}
