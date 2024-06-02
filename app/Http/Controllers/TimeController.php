<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeController extends Controller
{
  public function index() {

    $week = Carbon::now()->weekOfYear - 1;
    $year = Carbon::now()->year;

    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    $times = Time::query()
      ->with('project')
      ->with('category')
      ->with('user')
      ->withMinutes()
      ->byWeekOfYear($week, $year)
      ->orderBy('begin_at', 'desc')
      ->get();

    $groupedEntries = [];

    $sumByWeekday = collect([
      'Mo' => 0,
      'Di' => 0,
      'Mi' => 0,
      'Do' => 0,
      'Fr' => 0,
      'Sa' => 0,
      'So' => 0
    ]);


    foreach ($times->groupBy('ts') as $key => $value) {
      $groupedEntries[$key]['entries'] = $value;
      $groupedEntries[$key]['sum'] = $value->sum('mins');
      $sumByWeekday[Carbon::parse($key)->locale('de')->minDayName] = $groupedEntries[$key]['sum'];
    }

    return response()->json([
      'data' => $times,
      'groupedByDay' => $groupedEntries,
      'stats' => [
        'start' => $startOfWeek,
        'end' => $endOfWeek,
        'week' => $week,
        'sumByWeekday' => $sumByWeekday,
        'sumWeek' => $sumByWeekday->sum(),
      ]
    ]);
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required'
    ]);

    $contact = Time::create($validated);
    return response()->json([
      'contact' => $contact
    ]);
  }

  public function show(Time $time)
  {

    $time->load('project')->load('category')->load('user');

    return response()->json([
      'time' => $time
    ]);
  }

  public function update(Request $request, Time $time)
  {
    $validated = $request->validate([
      'name' => 'required'
    ]);

    $time->update($validated);

    return response()->json([
      'time' => $time
    ]);
  }

  public function destroy(Time $time)
  {
    //
  }
}
