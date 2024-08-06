<?php

namespace App\Http\Controllers;

use App\Http\Requests\NumberRangeRequest;
use App\Http\Resources\NumberRangeResource;
use App\Models\NumberRange;

class NumberRangeController extends Controller
{
    public function index()
    {
        return NumberRangeResource::collection(NumberRange::all());
    }

    public function store(NumberRangeRequest $request)
    {
        return new NumberRangeResource(NumberRange::create($request->validated()));
    }

    public function show(NumberRange $numberRange)
    {
        return new NumberRangeResource($numberRange);
    }

    public function update(NumberRangeRequest $request, NumberRange $numberRange)
    {
        $numberRange->update($request->validated());

        return new NumberRangeResource($numberRange);
    }

    public function destroy(NumberRange $numberRange)
    {
        $numberRange->delete();

        return response()->json();
    }
}
