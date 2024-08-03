<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class InvoicingSettings extends Settings
{
    public string $invoice_iban;

    public string $invoice_bic;

    public string $invoice_account_owner;

    public string $invoice_bank_name;

    public static function group(): string
    {
        return 'invoicing';
    }
}
