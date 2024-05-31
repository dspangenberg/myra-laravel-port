<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AddressCategory;
use Illuminate\Support\Facades\Storage;

class AddressCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      AddressCategory::truncate();

      $address_categories = Storage::disk('json')->json('address_categories.json');
      foreach ($address_categories as $key => $value) {
        AddressCategory::create([
          'id' => $value['id'],
          'name' => $value['name'],
          'type' => $value['type']
        ]);
      }
    }
}
