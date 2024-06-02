<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;
use App\Http\Resources\TimeCollection;
use Carbon\Carbon;


class TimeController extends Controller
{
  public function index() {

    $week = Carbon::now()->weekOfYear - 1;
    $year = Carbon::now()->year;

    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();

    dump($startOfWeek);

    $times = Time::query()
      ->with('project')
      ->with('category')
      ->with('user')
      ->withMinutes()
      ->byWeekOfYear($week, $year)
      ->orderBy('begin_at', 'desc')
      ->get();

    return response()->json([
      'data' => $times,
      'stats' => [
        'start' => $startOfWeek,
        'end' => $endOfWeek,
        'week' => $week,
      ]
    ]);

    // return new TimeCollection($times);
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

    $time->load('company')->load('title');

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
