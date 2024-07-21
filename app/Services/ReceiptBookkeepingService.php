<?php

namespace App\Services;

use App\Models\BookkeepingAccount;
use App\Models\BookkeepingBooking;
use App\Models\Contact;
use App\Models\Receipt;

class ReceiptBookkeepingService
{
    public static function runAll(): void
    {
        $receipts = Receipt::all();
        $receipts->each(function ($receipt) {
            self::run($receipt);
        });
    }

    public static function run(Receipt $receipt): void
    {
        $booking = BookkeepingBooking::firstOrNew(['receipt_id' => $receipt->id]);
        $instance = new ReceiptBookkeepingService();

        if ($booking->id && $booking->is_locked) {
            return;
        }

        $accounts = [
            'creditId' => 0,
            'debitId' => 0,
        ];

        $bookingText = '';

        if ($receipt->receipt_category_id === 13) {
            $contact = Contact::find($receipt->contact_id);

            $account = BookkeepingAccount::firstorNew(['account_number' => $contact->debtor_number]);
            if (! $account->id) {
                $account->account_number = $contact->debtor_number;
                $account->name = $contact->full_name;
                $account->tax_id = 0;
                $account->type = 'n';
                $account->save();
            }
            $accounts['debitId'] = $account->account_number;
            $accounts['creditId'] = $contact->outturn_account_id ? $contact->outturn_account_id : 8400;
            $bookingText = $contact->full_name.'|Ausgangsrechnung '.$receipt->reference;
        }

        if ($accounts['creditId'] && $accounts['debitId']) {
            $booking->initBooking('receipt', $receipt->id, $receipt->issued_on, $receipt->gross, $accounts['creditId'],
                $accounts['debitId'], $bookingText, $receipt->real_document_number);
            $booking->save();
        }

    }
}
