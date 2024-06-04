<?php

namespace App\Services;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimeService
{
  static public function getTimeByWeekOfYear(Int $week, Int $year): array {

    $date = Carbon::now();
    $date->setISODate($year, $week);

    $startOfWeek = $date->startOfWeek();
    $endOfWeek = $date->endOfWeek();

    $times = Time::query()
      ->with('project')
      ->with('category')
      ->with('user')
      ->withMinutes()
      ->byWeekOfYear($week, $year)
      ->orderBy('begin_at', 'desc')
      ->get();

    $groupedEntries = self::groupTimesByDate($times);
    $sumByWeekday = self::getSumByWeekday($groupedEntries);

    return [
      'stats' => [
        'startOfWeek' => $startOfWeek,
        'endOfWeek' => $endOfWeek,
        'week' => $week,
        'year' => $year,
        'sumByWeekday' => $sumByWeekday,
        'sumWeek' => $sumByWeekday->sum(),
      ],
      'times' => $times ,
      'groupedByDay' => $groupedEntries
    ];
  }

static function getSumByWeekday(Array $times): Collection {
    $sumByWeekday = collect([
      'Mo' => 0,
      'Di' => 0,
      'Mi' => 0,
      'Do' => 0,
      'Fr' => 0,
      'Sa' => 0,
      'So' => 0
    ]);

    foreach ($times as $key => $value) {
      $sumByWeekday[Carbon::parse($key)->locale('de')->minDayName] = $value['sum'];
    }
    return $sumByWeekday;
  }
static function groupTimesByDate(Collection $times): array {
    $groupedEntries = [];
    foreach ($times->groupBy('ts') as $key => $value) {
      $groupedEntries[$key]['entries'] = $value;
      $groupedEntries[$key]['date'] = Carbon::parse($key)->settings(['locale'=>'de'])->isoFormat('dddd, DD. MMMM YYYY');
      $groupedEntries[$key]['sum'] = $value->sum('mins');
    }
    return $groupedEntries;
  }
}
