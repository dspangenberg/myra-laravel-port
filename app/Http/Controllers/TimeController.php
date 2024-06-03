<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Project;
use App\Models\TimeCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

  public function create()
  {

    $lastEntry = Time::orderBy('id', 'desc')->first();
    dump($lastEntry);

    $time = new Time();
    $time->begin_at = Carbon::now();
    $time->end_at = null;
    $time->project_id = $lastEntry->project_id;
    $time->time_category_id = $lastEntry->time_category_id;
    $time->user_id = Auth::user()->id;
    $time->is_locked = $lastEntry->is_locked;
    $time->is_billable = $lastEntry->is_billable;
    $time->is_timer = false;

    return response()->json([
      'projects' => Project::orderBy('name')->where('is_archived', false)->get()->toArray(),
      'data' => $time,
      'categories' => TimeCategory::orderBy('name')->get()->toArray(),
      'users' => User::orderBy('last_name')->get()->toArray(),
    ]);
  }

  public function edit(Time $time)
  {

    $time->load('project')->load('category')->load('user');

    return response()->json([
      'projects' => Project::orderBy('name')->where('is_archived', false)->get()->toArray(),
      'data' => $time,
      'categories' => TimeCategory::orderBy('name')->get()->toArray(),
      'users' => User::orderBy('last_name')->get()->toArray(),
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
