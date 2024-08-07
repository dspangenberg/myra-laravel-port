<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\BankAccountResource;
use App\Http\Resources\TransactionResource;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $bankAccountId = $request->query('bank_account', 0);
        if (! $bankAccountId) {
            $bankAccountId = BankAccount::first()->id;
        }

        $transactions = Transaction::with('contact')
            ->with('booking')
            ->with('payable')
            ->where('bank_account_id', $bankAccountId)
            ->orderBy('booked_on')->paginate();

        return TransactionResource::collection($transactions)->additional([
            'bank_accounts' => BankAccountResource::collection(BankAccount::orderBy('pos')->get()),
        ]);
    }

    public function store(TransactionRequest $request)
    {
        return new TransactionResource(Transaction::create($request->validated()));
    }

    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->validated());

        return new TransactionResource($transaction);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json();
    }
}
