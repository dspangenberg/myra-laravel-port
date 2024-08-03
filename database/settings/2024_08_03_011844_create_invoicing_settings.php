<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('invoicing.invoice_iban', '');
        $this->migrator->add('invoicing.$invoice_bic', '');
        $this->migrator->add('invoicing.$invoice_account_owner', '');
    }
};
