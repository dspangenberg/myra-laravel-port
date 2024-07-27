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
        self::doMoneyTransits();

        $transactions = Transaction::all();
        $transactions->each(function ($transaction) {
            self::run($transaction);
        });
    }

    public static function doMoneyTransits(): void
    {
        $bankAccounts = BankAccount::pluck('iban')->toArray();
        $transactions = Transaction::whereIn('account_number', $bankAccounts)->orWhere('name', 'TWICEWARE SOLUTIONS E.K.')->get();
        $transactions->each(function ($transaction) {
            dump($transaction);
            $bankAccount = BankAccount::where('id', $transaction->bank_account_id)->first();
            $accounts['debitId'] = 1360;
            $accounts['creditId'] = $bankAccount->bookkeeping_account_id;
            $accounts['bookingText'] = '';
            $booking = BookkeepingBooking::firstOrNew(['transaction_id' => $transaction->id]);
            $booking->initBooking('transaction', $transaction->id, $transaction->booked_on, $transaction->amount, $accounts['creditId'], $accounts['debitId'], $accounts['bookingText'], $transaction->real_document_number, $transaction->comment);
            $booking->save();
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

        $debtorIbans = Contact::where('is_debtor', true)->whereNotNull('iban')->pluck('iban')->toArray();
        if (in_array($transaction->account_number, $debtorIbans)) {
            $accounts = $instance->bookDebtorPayments($transaction);
        }

        $creditorIbans = Contact::where('is_creditor', true)->whereNotNull('iban')->pluck('iban')->toArray();
        if (in_array($transaction->account_number, $creditorIbans)) {
            $accounts = $instance->bookCreditorPayments($transaction);
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

        dump($contact->toJson());

        return [
            'creditId' => $contact->debtor_number,
            'debitId' => $transaction->bank_account->bookkeeping_account_id,
            'bookingText' => $contact->full_name.'|Zahlungseingang '.$transaction->purpose,
        ];
    }

    public function bookCreditorPayments(Transaction $transaction): array
    {
        $contact = Contact::where('id', $transaction->contact_id)->first();
        if (! $contact) {
            dd('Contact not found', $transaction->contact_id, $transaction->id);
        }

        dump($contact->toJson());

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
