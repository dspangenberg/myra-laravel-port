<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Country::truncate();

      $countries = Storage::disk('json')->json('countries.json');
      foreach ($countries as $key => $value) {
        Country::create([
          'id' => $value['id'],
          'name' => $value['name'],
          'iso_code' => $value['iso_code'],
          'vehicle_code' => $value['vehicle_code'],
          'country_code' => $value['country_code']
        ]);
    }
  }
}
