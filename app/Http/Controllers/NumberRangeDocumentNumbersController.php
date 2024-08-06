<?php

namespace App\Http\Controllers;

use App\Http\Requests\NumberRangeDocumentNumbersRequest;
use App\Http\Resources\NumberRangeDocumentNumbersResource;
use App\Models\NumberRangeDocumentNumber;

class NumberRangeDocumentNumbersController extends Controller
{
    public function index()
    {
        return NumberRangeDocumentNumbersResource::collection(NumberRangeDocumentNumber::all());
    }

    public function store(NumberRangeDocumentNumbersRequest $request)
    {
        return new NumberRangeDocumentNumbersResource(NumberRangeDocumentNumber::create($request->validated()));
    }

    public function show(NumberRangeDocumentNumber $numberRangeDocumentNumbers)
    {
        return new NumberRangeDocumentNumbersResource($numberRangeDocumentNumbers);
    }

    public function update(NumberRangeDocumentNumbersRequest $request, NumberRangeDocumentNumber $numberRangeDocumentNumbers)
    {
        $numberRangeDocumentNumbers->update($request->validated());

        return new NumberRangeDocumentNumbersResource($numberRangeDocumentNumbers);
    }

    public function destroy(NumberRangeDocumentNumber $numberRangeDocumentNumbers)
    {
        $numberRangeDocumentNumbers->delete();

        return response()->json();
    }
}
