<?php

class LegacyInvoice extends Model
{
    use Sushi;

    public function ImportMoneyMoneyTransaction(): array
    {
        $jsonInvoices = Storage::disk('private')->json('invoices.json');

        return collect($jsonInvoices)->toArray();
    }
}
