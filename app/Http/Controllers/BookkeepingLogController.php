<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookkeepingLogRequest;
use App\Http\Resources\BookkeepingLogResource;
use App\Models\BookkeepingLog;

class BookkeepingLogController extends Controller
{
    public function index()
    {
        return BookkeepingLogResource::collection(BookkeepingLog::all());
    }

    public function store(BookkeepingLogRequest $request)
    {
        return new BookkeepingLogResource(BookkeepingLog::create($request->validated()));
    }

    public function show(BookkeepingLog $bookkeepingLog)
    {
        return new BookkeepingLogResource($bookkeepingLog);
    }

    public function update(BookkeepingLogRequest $request, BookkeepingLog $bookkeepingLog)
    {
        $bookkeepingLog->update($request->validated());

        return new BookkeepingLogResource($bookkeepingLog);
    }

    public function destroy(BookkeepingLog $bookkeepingLog)
    {
        $bookkeepingLog->delete();

        return response()->json();
    }
}
