<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Time;
use Illuminate\Support\Facades\Storage;

class TimeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Time::truncate();
    $times = Storage::disk('private')->json('times.json');
    foreach ($times as $key => $value) {
      Time::create([
        'id' => $value['id'],
        'project_id' => $value['project_id'] ?: 0,
        'time_category_id' => $value['time_category_id'] ?: 0,
        'subproject_id' => $value['subproject_id'] ?: 0,
        'task_id' => $value['task_id'] ?: 0,
        'user_id' => $value['user_id'] ?: 0,
        'invoice_id' => $value['invoice_id'] ?: 0,
        'note' => $value['note'] ?: '',
        'begin_at' => $value['begin_at'],
        'end_at' => $value['end_at'],
        'minutes' => $value['minutes'] ?: 0,
        'is_locked' => $value['is_locked'],
        'is_billable' => $value['is_billable'],
        'is_timer' => $value['is_timer'],
        'ping_at' => $value['ping_at'] == '0000-00-00 00:00:00' ? null : $value['ping_at'],
      ]);
    }
  }
}
