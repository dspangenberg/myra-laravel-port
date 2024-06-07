<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::truncate();
        $contacts = Storage::disk('private')->json('contacts.json');
        dump($contacts);
        foreach ($contacts as $key => $value) {
            Contact::create([
                'id' => $value['id'],
                'company_id' => $value['company_id'] ?: 0,
                'name' => $value['name'],
                'first_name' => $value['first_name'],
                'title_id' => $value['title_id'] ?: 0,
                'salutation_id' => $value['salutation_id'] ?: 0,
                'position' => $value['position'],
                'ref' => $value['ref'],
                'is_debtor' => $value['is_debtor'],
                'is_org' => $value['is_org'] ?: false,
                'is_creditor' => $value['is_creditor'],
                'debtor_number' => $value['debtor_number'],
                'creditor_number' => $value['creditor_number'],
                'is_archived' => $value['is_archived'],
                'archived_reason' => $value['archived_reason'],
                'payment_deadline_id' => $value['payment_deadline_id'] ?: 0,
                'tax_id' => $value['tax_id'] ?: 0,
                'register_court' => $value['register_court'],
                'register_number' => $value['register_number'],
                'vat_id' => $value['vat_id'],
                'website' => $value['website'],
                'note' => $value['note'],
                'dob' => $value['dob'],
            ]);
        }
    }
}
