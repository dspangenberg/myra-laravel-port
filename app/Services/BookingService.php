<?php

namespace App\Services;

use App\Models\BookkeepingAccount;
use App\Models\BookkeepingBooking;
use App\Models\Payment;

class BookingService
{
    public static function createCurrencyDifferenceBookings(int $year): void
    {
        $payments = Payment::where('is_confirmed', 1)
            ->with('payable')
            ->with('payable.contact')
            ->with('transaction')
            ->where('is_currency_difference', 1)
            // ->whereYear('issued_on', $year)
            ->get();

        if ($payments->count()) {
            $payments->each(function ($payment) {

                $accountDebit = BookkeepingAccount::where('account_number', $payment->amount > 0 ? '2150' : '2660')->first();
                $accountCredit = BookkeepingAccount::where('account_number', $payment->payable->contact->creditor_number)->first();

                $payment->amount = $payment->amount < 0 ? $payment->amount * -1 : $payment->amount;
                $bookingText = [];

                $bookingText[] = 'Währungsdifferenz';
                $bookingText[] = strtoupper($payment->payable->contact->full_name);

                if ($accountCredit) {
                    $existingBooking = BookkeepingBooking::whereMorphedTo('bookable', Payment::class)->where('bookable_id', $payment->id)->first();

                    $booking = BookkeepingBooking::createBooking($payment, 'issued_on', 'amount', $accountDebit,
                        $accountCredit, 'WUM',
                        $existingBooking ? $existingBooking->id : null
                    );
                    $booking->booking_text = implode('|', $bookingText);
                    $booking->number_range_document_numbers_id = $payment->transaction->number_range_document_numbers_id;
                    $booking->save();
                }
            });
        }
    }
}
