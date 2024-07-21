<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\BookkeepingBooking;
use App\Models\Transaction;

class TransactionsBookkeepingService
{
    public static function runAll(): void
    {
        $transactions = Transaction::all();
        $transactions->each(function ($transaction) {
            self::run($transaction);
        });
    }

    public static function run(Transaction $transaction): void
    {
        $booking = BookkeepingBooking::firstOrNew(['transaction_id' => $transaction->id]);
        $instance = new TransactionsBookkeepingService();

        $transaction->load('bank_account');

        if ($booking->id && $booking->is_locked) {
            return;
        }

        $accounts = [
            'creditId' => 0,
            'debitId' => 0,
        ];

        $bankAccounts = BankAccount::pluck('iban')->toArray();

        if (in_array($transaction->account_number, $bankAccounts)) {
            $bankAccount = BankAccount::where('iban', $transaction->account_number)->first();
            $accounts['debitId'] = 1360;
            $accounts['creditId'] = $bankAccount->bookkeeping_account_id;
        }

        if ($transaction->is_private) {
            $accounts = $instance->bookPrivate($transaction);
        }

        if ($accounts['creditId'] && $accounts['debitId']) {
            $booking->initBooking('transaction', $transaction->id, $transaction->booked_on, $transaction->amount, $accounts['creditId'], $accounts['debitId'], '', $transaction->real_document_number);
            $booking->save();
        }
    }

    public function bookPrivate(Transaction $transaction): array
    {
        return [
            'creditId' => $transaction->amount < 0 ? 1800 : 1890,
            'debitId' => $transaction->bank_account->bookkeeping_account_id,
        ];
    }
}
