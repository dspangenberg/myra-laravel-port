<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\BookkeepingBooking;
use App\Models\Contact;
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
            'bookingText' => '',
        ];

        $bankAccounts = BankAccount::pluck('iban')->toArray();

        if (in_array($transaction->account_number, $bankAccounts)) {
            $bankAccount = BankAccount::where('iban', $transaction->account_number)->first();
            $accounts['debitId'] = 1360;
            $accounts['creditId'] = $bankAccount->bookkeeping_account_id;
            $accounts['bookingText'] = '';
        }

        $debtorIbans = Contact::where('is_debtor', true)->whereNotNull('iban')->pluck('iban')->toArray();
        if (in_array($transaction->account_number, $debtorIbans)) {
            $accounts = $instance->bookDebtorPayments($transaction);
        }

        if ($transaction->is_private) {
            $accounts = $instance->bookPrivate($transaction);
        }

        if ($accounts['creditId'] && $accounts['debitId']) {
            $booking->initBooking('transaction', $transaction->id, $transaction->booked_on, $transaction->amount, $accounts['creditId'], $accounts['debitId'], $accounts['bookingText'], $transaction->real_document_number, $transaction->comment);
            $booking->save();
        }
    }

    public function bookDebtorPayments(Transaction $transaction): array
    {
        $contact = Contact::where('id', $transaction->contact_id)->first();
        if (! $contact) {
            dd('Contact not found', $transaction->contact_id, $transaction->id);
        }

        return [
            'creditId' => $contact->debtor_number,
            'debitId' => $transaction->bank_account->bookkeeping_account_id,
            'bookingText' => $contact->full_name.'|Zahlungseingang '.$transaction->purpose,
        ];
    }

    public function bookPrivate(Transaction $transaction): array
    {
        return [
            'creditId' => $transaction->amount < 0 ? 1800 : 1890,
            'debitId' => $transaction->bank_account->bookkeeping_account_id,
            'bookingText' => '',
        ];
    }
}
