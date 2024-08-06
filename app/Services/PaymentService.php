<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentSuggestion;
use App\Models\Receipt;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PaymentService
{
    public static function getPaymentsForInvoice(Invoice $invoice): void
    {
        $service = new PaymentService;

        $grossAmount = $invoice->lines_sum_amount + $invoice->lines_sum_tax;
        $purpose = '%'.Str::replace('RG-', '', $invoice->formated_invoice_number).'%';

        $transactions = $service->findTransactionByPurpose($purpose, $invoice->contact_id);
        $rank = 100;

        if ($transactions->count() === 0) {
            $transactions = $service->findTransactionByAmount($invoice, $grossAmount);
            $rank = 50;
        }

        $transactions->each(function ($transaction) use ($invoice) {
            $existingPayment = Payment::with('transaction')->with('transaction.bank_account')
                ->whereMorphedTo('payable', Invoice::class)
                ->where('payable_id', $invoice->id)
                ->where('transaction_id', $transaction->id)
                ->first();

            $payment = Payment::firstOrNew(['id' => $existingPayment ? $existingPayment->id : null]);

            if ($payment->is_confirmed) {
                return false;
            }

            $payment->transaction_id = $transaction->id;
            $payment->amount = $transaction->amount;
            $payment->issued_on = $transaction->booked_on;
            $payment->payable()->associate($invoice);
            $payment->is_confirmed = true;
            $payment->save();
        });

        $service->createPayments($transactions, $invoice, $rank);
    }

    public function findTransactionByPurpose(string $purpose, $contactId = 0): Collection
    {

        return Transaction::where('is_private', 0)->where('contact_id', $contactId)->where('purpose', 'LIKE', $purpose)->dump()->get();

    }

    public function findTransactionByAmount(Invoice|Receipt $item, $amount): Collection
    {
        return Transaction::where('contact_id', $item->contact_id)
            ->where('is_private', 0)
            ->where('amount', $amount)
            ->get();
    }

    public function createPayments(Collection $transactions, Invoice|Receipt $item, int $rank): void
    {

        $model = $item->getMorphClass();
        $transactionCount = $transactions->count();

        $transactions->each(function ($transaction) use ($model, $item, $rank, $transactionCount) {
            $existingPayment = Payment::with('transaction')->with('transaction.bank_account')
                ->whereMorphedTo('payable', $model)
                ->where('payable_id', $item->id)
                ->where('transaction_id', $transaction->id)
                ->first();

            $id = $existingPayment ? $existingPayment->id : null;
            if ($existingPayment && $existingPayment->is_confirmed) {
                return false;
            }

            $orgRank = $rank;
            if ($model === 'App\Models\Receipt' && $transactionCount > 1) {
                $rank = $item->issued_on->diffInDays($transaction->booked_on);
                if ($rank < 30) {
                    $rank = 30;
                }
            }

            if ($rank > 30) {
                $payment = Payment::firstOrNew(['id' => $id]);
                $payment->rank = $orgRank;
            } else {
                $payment = new PaymentSuggestion;
                $payment->rank = $rank;
            }

            $payment->transaction_id = $transaction->id;
            $payment->amount = $transaction->amount;
            $payment->issued_on = $transaction->booked_on;
            $payment->payable()->associate($item);
            $payment->is_confirmed = $rank > 25;
            if ($rank > 0) {
                $payment->save();
            }
        });
    }

    public static function getPaymentsForReceipt(Receipt $receipt): ?Collection
    {

        $service = new PaymentService;
        $transactions = $service->findTransactionByPurpose('%'.$receipt->reference.'%', $receipt->contact_id);
        $rank = 100;

        if ($transactions->count() === 0) {
            $transactions = $service->findTransactionByAmount($receipt, $receipt->gross);
            $rank = $transactions->count() > 1 ? $transactions->count() : 50;
            if ($transactions->count() === 0) {
                $transactions = $service->findTransactionByContact($receipt);
            }
        }

        if ($transactions->count() === 0) {
            return null;
        }

        $service->createPayments($transactions, $receipt, $rank);
        if ($transactions->count() > 0) {
            /*
            $bestPayment = Payment::whereMorphedTo('payable', 'App\Models\Receipt')
                ->where('payable_id', $receipt->id)
                ->where('rank', '<=', 0)
                ->orderBy('rank', 'desc')
                ->first();
            if ($bestPayment) {
                $bestPayment->rank = 25;
                $bestPayment->save();
            }
            */
        }

        $payments = PaymentSuggestion::whereMorphedTo('payable', 'App\Models\Receipt')
            ->with('transaction')
            ->with('transaction.contact')
            ->where('payable_id', $receipt->id)
            // ->where('rank', '<=', 25)
            // ->where('is_confirmed', false)
            ->orderBy('rank')
            ->get();

        return $payments;

    }

    public function findTransactionByContact(Invoice|Receipt $item): Collection
    {
        return Transaction::where('contact_id', $item->contact_id)
            ->where('is_private', 0)
            ->get();
    }

    public static function adjustPaymentForReciept(int $id)
    {
        $suggestedPayment = PaymentSuggestion::with('transaction')->find($id);
        $data = $suggestedPayment->toArray();
        unset($data['id']);
        $payment = new Payment($data);
        $payment->rank = 100;
        $payment->is_confirmed = true;
        $payment->save();

        $receipt = Receipt::find($suggestedPayment->payable_id);
        if ($receipt->gross !== $payment->amount) {
            if ($receipt->currency_code !== 'EUR') {
                $currencyDifferency = $payment->amount - $receipt->gross;
                $differencePayment = new Payment;
                $differencePayment->payable()->associate($receipt);
                $differencePayment->issued_on = $payment->issued_on;
                $differencePayment->transaction_id = $suggestedPayment->transaction_id;
                $differencePayment->amount = $currencyDifferency * -1;
                $differencePayment->is_confirmed = true;
                $differencePayment->is_currency_difference = true;
                $differencePayment->save();
            }
        }

        PaymentSuggestion::where('transaction_id', $payment->transaction_id)->forceDelete();
    }
}
