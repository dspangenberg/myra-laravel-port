<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRuleRequest;
use App\Http\Resources\TransactionRuleResource;
use App\Models\TransactionRule;

class TransactionRuleController extends Controller
{
    public function index()
    {
        return TransactionRuleResource::collection(TransactionRule::all());
    }

    public function store(TransactionRuleRequest $request)
    {
        return new TransactionRuleResource(TransactionRule::create($request->validated()));
    }

    public function show(TransactionRule $transactionRule)
    {
        return new TransactionRuleResource($transactionRule);
    }

    public function update(TransactionRuleRequest $request, TransactionRule $transactionRule)
    {
        $transactionRule->update($request->validated());

        return new TransactionRuleResource($transactionRule);
    }

    public function destroy(TransactionRule $transactionRule)
    {
        $transactionRule->delete();

        return response()->json();
    }
}
