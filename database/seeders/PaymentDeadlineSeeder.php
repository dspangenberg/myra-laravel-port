<?php

namespace Database\Seeders;

use App\Models\PaymentDeadline;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class PaymentDeadlineSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    PaymentDeadline::truncate();

    $payment_deadlines = Storage::disk('json')->json('payment_deadlines.json');
    foreach ($payment_deadlines as $key => $value) {
      PaymentDeadline::create([
        'id' => $value['id'],
        'name' => $value['name'],
        'days' => $value['days'],
        'is_immediately' => $value['is_immediately'],
        'is_default' => $value['is_default']
      ]);
    }
  }
}
