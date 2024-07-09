<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeRequest;
use App\Models\Project;
use App\Models\Time;
use App\Models\TimeCategory;
use App\Models\User;
use App\Services\PdfService;
use App\Services\TimeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\MpdfException;

class TimeController extends Controller
{
    /**
     * @throws MpdfException
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'week');

        $perPage = $request->expectsJson() ? $this->recordsPerPage : 1000;

        if ($type === 'week') {
            $week = Carbon::now()->weekOfYear;
            $year = Carbon::now()->year;

            $filters = $request->query('filter');
            if ($filters) {
                $week = $filters['week'] ?: $week;
                $year = $filters['year'] ?: $year;
            }
            $times = TimeService::getTimeByWeekOfYear($week, $year);
        } else {

            $times = TimeService::filter($request, $perPage);
        }

        if ($request->expectsJson()) {
            return response()->json($times);
        }

        $now = Carbon::now()->format('d.m.Y');
        $title = "Leistungsnachweis vom $now";

        $pdfContent = PdfService::createPdf('proof-of-activity', 'pdf.proof-of-activity.index', ['times' => $times, ''], [
            'title' => $title,
        ]);

        return response($pdfContent);
    }

    public function create()
    {

        $lastEntry = Time::orderBy('id', 'desc')->first();

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
            'time' => $time,
        ]);
    }

    public function show(Time $time)
    {

        $time->load('project')->load('category')->load('user');

        return response()->json([
            'time' => $time,
        ]);
    }

    public function update(StoreTimeRequest $request, Time $time)
    {
        $time->update($request->validated());

        return response()->json([
            'time' => $time,
        ]);
    }

    public function destroy(Time $time)
    {
        //
    }
}
