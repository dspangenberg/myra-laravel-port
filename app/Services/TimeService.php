<?php

namespace App\Services;

use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TimeService
{
    public static function getTimeByWeekOfYear(int $week, int $year): array
    {

        $date = Carbon::now();
        $date->setISODate($year, $week);

        $startOfWeek = $date->startOfWeek();
        $endOfWeek = $date->endOfWeek();

        $times = Time::query()
            ->with('project')
            ->with('category')
            ->with('user')
            ->withMinutes()
            ->whereNotNull('begin_at')
            ->byWeekOfYear($week, $year)
            ->orderBy('begin_at', 'desc')
            ->get();

        $groupedEntries = self::groupByDate($times);
        $sumByWeekday = self::getSumByWeekday($groupedEntries);
        $groupedByProjectandDate = self::groupByProjectsAndDate($times);

        $sum = collect($groupedByProjectandDate)->sum('sum');

        return [
            'stats' => [
                'start' => $startOfWeek,
                'end' => $endOfWeek,
                'week' => $week,
                'year' => $year,
                'sumByWeekday' => $sumByWeekday,
                'sumWeek' => $sumByWeekday->sum(),
                'sum' => $sum,
            ],
            'projectStats' => [],
            'data' => $times,
            'meta' => [],
            'groupedByProject' => $groupedByProjectandDate,
            'groupedByDate' => $groupedEntries,
        ];
    }

    public static function filter($request, $perPage): array
    {
        $times = QueryBuilder::for(Time::class, $request)
            ->allowedFilters([
                'project_id',
                AllowedFilter::scope('view'),
            ])
            ->with('project')
            ->withMinutes()
            ->with('category')
            ->with('user')
            ->whereNotNull('begin_at')
            ->whereNotNull('end_at')
            ->orderBy('begin_at', 'desc')
            ->where('begin_at', '>=', Carbon::now()->subtract('years', 1))
            ->paginate($perPage, $request->get('page', 1));

        $groupedByDate = self::groupByDate(collect($times->items()));
        $sum = collect($groupedByDate)->sum('sum');
        $end = collect($groupedByDate)->last();

        return [
            'stats' => [
                'start' => Carbon::now(),
                'end' => $end ? $end['date'] : Carbon::now(),
                'sum' => $sum,
            ],
            'data' => $times->items(),
            'meta' => [
                'total' => $times->total(),
                'per_page' => $times->perPage(),
                'from' => $times->firstItem(),
                'current_page' => $times->currentPage(),
                'to' => $times->lastItem(),
            ],
            'groupedByProject' => self::groupByProjectsAndDate(collect($times->items())),
            'groupedByDate' => $groupedByDate,
        ];
    }

    public static function getSumByWeekday(array $times): Collection
    {
        $sumByWeekday = collect([
            'Mo' => 0,
            'Di' => 0,
            'Mi' => 0,
            'Do' => 0,
            'Fr' => 0,
            'Sa' => 0,
            'So' => 0,
        ]);

        foreach ($times as $key => $value) {
            $sumByWeekday[Carbon::parse($key)->locale('de')->minDayName] = $value['sum'];
        }

        return $sumByWeekday;
    }

    public static function groupByDate(Collection $times, $withSum = false): array
    {
        $groupedEntries = [];
        $sum = 0;
        foreach ($times->groupBy('ts') as $key => $value) {
            $groupedEntries[$key]['entries'] = $value->sortBy(['begin_at', 'asc']);
            $groupedEntries[$key]['date'] = Carbon::parse($key);
            $groupedEntries[$key]['formatedDate'] = Carbon::parse($key)->settings(['locale' => 'de'])->isoFormat('dddd, DD. MMMM YYYY');
            $groupedEntries[$key]['sum'] = $value->sum('mins');
            $sum = $sum + $groupedEntries[$key]['sum'];
        }
        if ($withSum) {
            return ['entries' => $groupedEntries, 'sum' => $sum];
        }

        return $groupedEntries;
    }

    public static function groupByProjectsAndDate(Collection $times): array
    {

        $projects = $times->pluck('project.name', 'project.id');

        $groupedEntries = [];
        foreach ($times->groupBy('project.id') as $key => $value) {
            $groupedByDate = self::groupByDate($value, true);
            $groupedEntries[$key]['entries'] = collect($groupedByDate['entries'])->sortBy(['date', 'asc']);
            $groupedEntries[$key]['sum'] = $groupedByDate['sum'];
            $groupedEntries[$key]['name'] = $projects->get($key);
        }

        return collect($groupedEntries)->sortBy(['name', 'asc'])->toArray();
    }
}
