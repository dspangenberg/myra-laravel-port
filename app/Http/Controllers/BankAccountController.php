<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankAccountRequest;
use App\Http\Resources\BankAccountResource;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
        return BankAccountResource::collection(BankAccount::all());
    }

    public function store(BankAccountRequest $request)
    {
        return new BankAccountResource(BankAccount::create($request->validated()));
    }

    public function show(BankAccount $bankAccount)
    {
        return new BankAccountResource($bankAccount);
    }

    public function update(BankAccountRequest $request, BankAccount $bankAccount)
    {
        $bankAccount->update($request->validated());

        return new BankAccountResource($bankAccount);
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        return response()->json();
    }
}
