<?php

class LegacyInvoice extends Model
{
    use Sushi;

    public function MoneyMoneyTransaction(): array
    {
        $jsonInvoices = Storage::disk('private')->json('invoices.json');

        return collect($jsonInvoices)->toArray();
    }
}
