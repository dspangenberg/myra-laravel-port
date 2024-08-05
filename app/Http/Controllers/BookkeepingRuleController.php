<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookkeepingRuleRequest;
use App\Http\Resources\BookkeepingRuleResource;
use App\Models\BookkeepingRule;

class BookkeepingRuleController extends Controller
{
    public function index()
    {
        return BookkeepingRuleResource::collection(BookkeepingRule::all());
    }

    public function store(BookkeepingRuleRequest $request)
    {
        return new BookkeepingRuleResource(BookkeepingRule::create($request->validated()));
    }

    public function show(BookkeepingRule $bookkeepingRule)
    {
        return new BookkeepingRuleResource($bookkeepingRule);
    }

    public function update(BookkeepingRuleRequest $request, BookkeepingRule $bookkeepingRule)
    {
        $bookkeepingRule->update($request->validated());

        return new BookkeepingRuleResource($bookkeepingRule);
    }

    public function destroy(BookkeepingRule $bookkeepingRule)
    {
        $bookkeepingRule->delete();

        return response()->json();
    }
}
