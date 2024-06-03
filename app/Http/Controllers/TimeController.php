<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;
use App\Services\TimeService;
use Carbon\Carbon;
use App\Http\Requests\StoreTimeRequest;

class TimeController extends Controller
{
  public function index(Request $request) {

    $times = [];

    $type = $request->query('type', 'week');
    if ($type === 'week') {
      $week = $request->query('week', Carbon::now()->weekOfYear);
      $year = $request->query('year', Carbon::now()->year);
      $times = TimeService::getTimeByWeekOfYear($week, $year);
    }

    return response()->json([
      'data' => $times['times'],
      'groupedByDay' => $times['groupedByDay'],
      'stats' => $times['stats']
    ]);
  }

  public function store(StoreTimeRequest $request)
  {

    $time = Time::create($request->validated());
    return response()->json([
      'contact' => $time
    ]);
  }

  public function show(Time $time)
  {

    $time->load('project')->load('category')->load('user');

    return response()->json([
      'time' => $time
    ]);
  }

  public function update(StoreTimeRequest $request, Time $time)
  {
    $time->update($request->validated());

    return response()->json([
      'time' => $time
    ]);
  }

  public function destroy(Time $time)
  {
    //
  }
}
