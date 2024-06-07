<?php

namespace App\Services;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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

    $groupedEntries = self::groupTimesByDate($times->toArray());
    $sumByWeekday = self::getSumByWeekday($groupedEntries);

    return [
      'stats' => [
        'start' => $startOfWeek,
        'end' => $endOfWeek,
        'week' => $week,
        'year' => $year,
        'sumByWeekday' => $sumByWeekday,
        'sumWeek' => $sumByWeekday->sum(),
      ],
      'times' => $times ,
      'meta' => [],
      'groupedByDay' => $groupedEntries
    ];
  }

  static function oldestEntry($request): string {
    $last = QueryBuilder::for(Time::class, $request)
      ->allowedFilters([
      AllowedFilter::scope('view'),
    ])
      ->with('project')
      ->withMinutes()
      ->orderBy('begin_at', 'asc')
      ->whereNotNull('begin_at')
      ->first();
    return $last['begin_at']->format('d.m.Y');
  }
  static function filter($request, $perPage): array {
      $filteredTimes = QueryBuilder::for(Time::class, $request)
      ->allowedFilters([
        AllowedFilter::scope('view'),
      ])
      ->with('project')
      ->withMinutes()
      ->with('category')
      ->with('user')
      ->orderBy('begin_at', 'desc')
      ->paginate($perPage, $request->get('page', 1));

      return $filteredTimes->toArray();
  }

static function getProjectStats ($request, $times): array {
  $filters = $request->query('filter');
  if ($filters['view'] === 'billable') {
    $end = self::oldestEntry($request);
    $stop = null;
  } else {
    $stop = Carbon::now()->subtract('months', 3);
    $end = Carbon::now()->subtract('months', 3)->format('d.m.Y');
  }

  $timeByProjects = QueryBuilder::for(Time::class, $request)
    ->allowedFilters([
      AllowedFilter::scope('view'),
    ])
    ->maxDuration($stop)
    ->selectRaw('project_id, projects.name, SUM(TIMESTAMPDIFF(MINUTE, begin_at, end_at)) as mins')
    ->join('projects', 'projects.id', 'times.project_id')
    ->groupBy('project_id')
    ->get();

  $sortedProjectEntries=[];
  $sortedProject = collect($timeByProjects->sortBy( ['name', 'asc']));
  foreach ($sortedProject->groupBy('name') as $key => $value) {
    $sortedProjectEntries[$key] = $value;
  }

  $stats = [
    'start' => Carbon::now()->format('d.m.Y'),
    'end' => $end
  ];

  return ['sortedProjectEntries' => $sortedProjectEntries, 'stats' => $stats];
}
static function getTimesFromQuery (array $times): array {
  $groupedEntries = self::groupTimesByDate($times['data']);
  return [
    'stats' => [
    ],
    'times' => $times,
    'meta' => [
      'total' => $times['total'],
      'per_page' => $times['per_page'],
      'from' => $times['from'],
      'current_page' => $times['current_page'],
      'to' => $times['to']
    ],
    'groupedByDay' => $groupedEntries
  ];
}

static function getSumByWeekday(array $times): Collection {
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
static function groupTimesByDate(array $times): array {
    $groupedEntries = [];
    foreach (collect($times)->groupBy('ts') as $key => $value) {
      $groupedEntries[$key]['entries'] = $value;
      $groupedEntries[$key]['date'] = Carbon::parse($key)->settings(['locale'=>'de'])->isoFormat('dddd, DD. MMMM YYYY');
      $groupedEntries[$key]['sum'] = $value->sum('mins');
    }
    return $groupedEntries;
  }
}
