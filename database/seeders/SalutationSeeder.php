<?php

namespace Database\Seeders;

use App\Models\Salutation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SalutationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Salutation::truncate();

        $salutations = Storage::disk('json')->json('salutations.json');
        foreach ($salutations as $key => $value) {
            Salutation::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'gender' => $value['gender'],
                'is_hidden' => $value['is_hidden'],
            ]);
        }
    }
}
