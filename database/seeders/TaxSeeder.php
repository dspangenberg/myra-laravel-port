<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tax::truncate();

        $taxes = Storage::disk('json')->json('taxes.json');
        foreach ($taxes as $key => $value) {
            Tax::create([
                'id' => $value['id'],
                'name' => $value['name'],
                'invoice_text' => $value['invoice_text'],
                'value' => $value['value'],
                'needs_vat_id' => $value['needs_vat_id'],
                'is_default' => $value['is_default'],
            ]);
        }
    }
}
