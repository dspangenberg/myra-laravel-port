<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->rename('invoicing.$invoice_bic', 'invoicing.invoice_bic');
        $this->migrator->rename('invoicing.$invoice_account_owner', 'invoicing.invoice_account_owner');
    }
};
