<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AddressCategory newModelQuery()
 * @method static Builder|AddressCategory newQuery()
 * @method static Builder|AddressCategory query()
 * @method static Builder|AddressCategory whereCreatedAt($value)
 * @method static Builder|AddressCategory whereId($value)
 * @method static Builder|AddressCategory whereName($value)
 * @method static Builder|AddressCategory whereType($value)
 * @method static Builder|AddressCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class AddressCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $iban
 * @property string $bic
 * @property string $bank_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $prefix
 * @property int $bookkeeping_account_id
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBookkeepingAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BankAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankBookingKey whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BankBookingKey extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $account_number
 * @property string $name
 * @property string $type
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $tax_id
 * @method static Builder|BookkeepingAccount newModelQuery()
 * @method static Builder|BookkeepingAccount newQuery()
 * @method static Builder|BookkeepingAccount query()
 * @method static Builder|BookkeepingAccount whereAccountNumber($value)
 * @method static Builder|BookkeepingAccount whereCreatedAt($value)
 * @method static Builder|BookkeepingAccount whereId($value)
 * @method static Builder|BookkeepingAccount whereIsDefault($value)
 * @method static Builder|BookkeepingAccount whereName($value)
 * @method static Builder|BookkeepingAccount whereTaxId($value)
 * @method static Builder|BookkeepingAccount whereType($value)
 * @method static Builder|BookkeepingAccount whereUpdatedAt($value)
 * @property-read string $label
 * @property-read \App\Models\Tax|null $tax
 * @mixin Eloquent
 */
	class BookkeepingAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $receipt_id
 * @property int $payment_id
 * @property int $account_id_credit
 * @property string $account_id_debit
 * @property float $amount
 * @property Carbon $date
 * @property int $tax_id
 * @property int $is_split
 * @property int $split_id
 * @property string $booking_text
 * @property string $document_number
 * @property string|null $note
 * @property float $tax_credit
 * @property float $tax_debit
 * @property int $is_locked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|BookkeepingBooking newModelQuery()
 * @method static Builder|BookkeepingBooking newQuery()
 * @method static Builder|BookkeepingBooking query()
 * @method static Builder|BookkeepingBooking whereAccountIdCredit($value)
 * @method static Builder|BookkeepingBooking whereAccountIdDebit($value)
 * @method static Builder|BookkeepingBooking whereAmount($value)
 * @method static Builder|BookkeepingBooking whereBookingText($value)
 * @method static Builder|BookkeepingBooking whereCreatedAt($value)
 * @method static Builder|BookkeepingBooking whereDate($value)
 * @method static Builder|BookkeepingBooking whereDocumentNumber($value)
 * @method static Builder|BookkeepingBooking whereId($value)
 * @method static Builder|BookkeepingBooking whereIsLocked($value)
 * @method static Builder|BookkeepingBooking whereIsSplit($value)
 * @method static Builder|BookkeepingBooking whereNote($value)
 * @method static Builder|BookkeepingBooking wherePaymentId($value)
 * @method static Builder|BookkeepingBooking whereReceiptId($value)
 * @method static Builder|BookkeepingBooking whereSplitId($value)
 * @method static Builder|BookkeepingBooking whereTaxCredit($value)
 * @method static Builder|BookkeepingBooking whereTaxDebit($value)
 * @method static Builder|BookkeepingBooking whereTaxId($value)
 * @method static Builder|BookkeepingBooking whereTransactionId($value)
 * @method static Builder|BookkeepingBooking whereUpdatedAt($value)
 * @property-read BookkeepingAccount|null $account_credit
 * @property-read BookkeepingAccount|null $account_debit
 * @property-read Tax|null $tax
 * @mixin Eloquent
 * @property string $bookable_type
 * @property int $bookable_id
 * @property int $is_marked
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $bookable
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingBooking whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingBooking whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookkeepingBooking whereIsMarked($value)
 */
	class BookkeepingBooking extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $is_org
 * @property string $name
 * @property int|null $title_id
 * @property int|null $salutation_id
 * @property string|null $first_name
 * @property string|null $position
 * @property string|null $department
 * @property string|null $short_name
 * @property string|null $ref
 * @property int|null $catgory_id
 * @property int|null $is_debtor
 * @property int|null $is_creditor
 * @property int|null $debtor_number
 * @property int|null $creditor_number
 * @property int|null $is_archived
 * @property string|null $archived_reason
 * @property int|null $has_dunning_block
 * @property int|null $payment_deadline_id
 * @property int|null $tax_id
 * @property string|null $hourly
 * @property string|null $register_court
 * @property string|null $register_number
 * @property string|null $vat_id
 * @property string|null $website
 * @property string|null $note
 * @property string|null $dob
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Contact|null $company
 * @property-read string $full_name
 * @property-read string $initials
 * @property-read string $reverse_full_name
 * @property-read Title|null $title
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Builder|Contact whereArchivedReason($value)
 * @method static Builder|Contact whereCatgoryId($value)
 * @method static Builder|Contact whereCompanyId($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereCreditorNumber($value)
 * @method static Builder|Contact whereDebtorNumber($value)
 * @method static Builder|Contact whereDeletedAt($value)
 * @method static Builder|Contact whereDepartment($value)
 * @method static Builder|Contact whereDob($value)
 * @method static Builder|Contact whereFirstName($value)
 * @method static Builder|Contact whereHasDunningBlock($value)
 * @method static Builder|Contact whereHourly($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereIsArchived($value)
 * @method static Builder|Contact whereIsCreditor($value)
 * @method static Builder|Contact whereIsDebtor($value)
 * @method static Builder|Contact whereIsOrg($value)
 * @method static Builder|Contact whereName($value)
 * @method static Builder|Contact whereNote($value)
 * @method static Builder|Contact wherePaymentDeadlineId($value)
 * @method static Builder|Contact wherePosition($value)
 * @method static Builder|Contact whereRef($value)
 * @method static Builder|Contact whereRegisterCourt($value)
 * @method static Builder|Contact whereRegisterNumber($value)
 * @method static Builder|Contact whereSalutationId($value)
 * @method static Builder|Contact whereShortName($value)
 * @method static Builder|Contact whereTaxId($value)
 * @method static Builder|Contact whereTitleId($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @method static Builder|Contact whereVatId($value)
 * @method static Builder|Contact whereWebsite($value)
 *                                                     *
 * @property-read Salutation|null $salutation
 * @property-read PaymentDeadline|null $payment_deadline
 * @property-read Tax|null $tax
 * @property string|null $tax_number
 * @property-read Collection<int, ContactAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @method static Builder|Contact whereTaxNumber($value)
 * @property-read Collection<int, ContactMail> $mails
 * @property-read int|null $mails_count
 * @property-read Collection<int, ContactPhone> $phones
 * @property-read int|null $phones_count
 * @property string|null $receipts_ref
 * @property string|null $iban
 * @method static Builder|Contact whereIban($value)
 * @method static Builder|Contact whereReceiptsRef($value)
 * @property int $outturn_account_id
 * @property bool $is_primary
 * @property string|null $paypal_email
 * @property string|null $cc_name
 * @method static Builder|Contact view($view)
 * @method static Builder|Contact whereCcName($value)
 * @method static Builder|Contact whereIsPrimary($value)
 * @method static Builder|Contact whereOutturnAccountId($value)
 * @method static Builder|Contact wherePaypalEmail($value)
 * @mixin Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property string|null $address
 * @property string $zip
 * @property string $city
 * @property int $address_category_id
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ContactAddress newModelQuery()
 * @method static Builder|ContactAddress newQuery()
 * @method static Builder|ContactAddress query()
 * @method static Builder|ContactAddress whereAddress($value)
 * @method static Builder|ContactAddress whereAddressCategoryId($value)
 * @method static Builder|ContactAddress whereCity($value)
 * @method static Builder|ContactAddress whereContactId($value)
 * @method static Builder|ContactAddress whereCountryId($value)
 * @method static Builder|ContactAddress whereCreatedAt($value)
 * @method static Builder|ContactAddress whereId($value)
 * @method static Builder|ContactAddress whereUpdatedAt($value)
 * @method static Builder|ContactAddress whereZip($value)
 * @property-read \App\Models\AddressCategory|null $category
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\Country|null $country
 * @mixin Eloquent
 */
	class ContactAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property int $email_category_id
 * @property int $pos
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ContactMail newModelQuery()
 * @method static Builder|ContactMail newQuery()
 * @method static Builder|ContactMail query()
 * @method static Builder|ContactMail whereContactId($value)
 * @method static Builder|ContactMail whereCreatedAt($value)
 * @method static Builder|ContactMail whereEmail($value)
 * @method static Builder|ContactMail whereEmailCategoryId($value)
 * @method static Builder|ContactMail whereId($value)
 * @method static Builder|ContactMail wherePos($value)
 * @method static Builder|ContactMail whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class ContactMail extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property int $phone_category_id
 * @property int $pos
 * @property string $phone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ContactPhone newModelQuery()
 * @method static Builder|ContactPhone newQuery()
 * @method static Builder|ContactPhone query()
 * @method static Builder|ContactPhone whereContactId($value)
 * @method static Builder|ContactPhone whereCreatedAt($value)
 * @method static Builder|ContactPhone whereId($value)
 * @method static Builder|ContactPhone wherePhone($value)
 * @method static Builder|ContactPhone wherePhoneCategoryId($value)
 * @method static Builder|ContactPhone wherePos($value)
 * @method static Builder|ContactPhone whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class ContactPhone extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $currency_code
 * @property int $year
 * @property int $month
 * @property float $rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ConversionRate newModelQuery()
 * @method static Builder|ConversionRate newQuery()
 * @method static Builder|ConversionRate query()
 * @method static Builder|ConversionRate whereCreatedAt($value)
 * @method static Builder|ConversionRate whereCurrencyCode($value)
 * @method static Builder|ConversionRate whereId($value)
 * @method static Builder|ConversionRate whereMonth($value)
 * @method static Builder|ConversionRate whereRate($value)
 * @method static Builder|ConversionRate whereUpdatedAt($value)
 * @method static Builder|ConversionRate whereYear($value)
 * @mixin Eloquent
 */
	class ConversionRate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property string $vehicle_code
 * @property string $country_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCountryCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereIsoCode($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @method static Builder|Country whereVehicleCode($value)
 * @mixin Eloquent
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EmailCategory newModelQuery()
 * @method static Builder|EmailCategory newQuery()
 * @method static Builder|EmailCategory query()
 * @method static Builder|EmailCategory whereCreatedAt($value)
 * @method static Builder|EmailCategory whereId($value)
 * @method static Builder|EmailCategory whereName($value)
 * @method static Builder|EmailCategory whereType($value)
 * @method static Builder|EmailCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class EmailCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property int $project_id
 * @property int $invoice_number
 * @property Carbon $issued_on
 * @property Carbon $due_on
 * @property int $dunning_block
 * @property int $is_draft
 * @property int $type_id
 * @property string $service_provision
 * @property string $vat_id
 * @property string $address
 * @property int $payment_deadline_id
 * @property Carbon|null $sent_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAddress($value)
 * @method static Builder|Invoice whereContactId($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereDueOn($value)
 * @method static Builder|Invoice whereDunningBlock($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceNumber($value)
 * @method static Builder|Invoice whereIsDraft($value)
 * @method static Builder|Invoice whereIssuedOn($value)
 * @method static Builder|Invoice wherePaymentDeadlineId($value)
 * @method static Builder|Invoice whereProjectId($value)
 * @method static Builder|Invoice whereSentAt($value)
 * @method static Builder|Invoice whereServiceProvision($value)
 * @method static Builder|Invoice whereTypeId($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereVatId($value)
 * @mixin Eloquent
 * @property int $legacy_id
 * @property-read \App\Models\BookkeepingBooking|null $booking
 * @property-read string $formated_invoice_number
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceLine> $lines
 * @property-read int|null $lines_count
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereLegacyId($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $invoice_id
 * @property float|null $quantity
 * @property string|null $unit
 * @property string $text
 * @property float|null $price
 * @property float|null $amount
 * @property float|null $tax
 * @property int $tax_id
 * @property int $pos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $type_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $legacy_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereLegacyId($value)
 */
	class InvoiceLine extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $parent_id
 * @property string $transaction_id
 * @property string $paypal_reference_id
 * @property string $paypal_reference_id_type
 * @property string $transaction_event_code
 * @property string $transaction_initiation_date
 * @property string $transaction_updated_date
 * @property float $transaction_amount
 * @property string $transaction_currency
 * @property string $transaction_status
 * @property string $payer_name
 * @property string $payer_email
 * @property string $transaction_subject
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePayerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePaypalReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePaypalReferenceIdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionEventCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionInitiationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionUpdatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PayPalTransactions extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $receipt_id
 * @property int $transaction_id
 * @property float $amount
 * @property int $bookkeeping_account_id
 * @property int $split_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereBookkeepingAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSplitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $days
 * @property int $is_immediately
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PaymentDeadline newModelQuery()
 * @method static Builder|PaymentDeadline newQuery()
 * @method static Builder|PaymentDeadline query()
 * @method static Builder|PaymentDeadline whereCreatedAt($value)
 * @method static Builder|PaymentDeadline whereDays($value)
 * @method static Builder|PaymentDeadline whereId($value)
 * @method static Builder|PaymentDeadline whereIsDefault($value)
 * @method static Builder|PaymentDeadline whereIsImmediately($value)
 * @method static Builder|PaymentDeadline whereName($value)
 * @method static Builder|PaymentDeadline whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class PaymentDeadline extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $receipt_id
 * @property string $transaction_id
 * @property int $confidence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereConfidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PaymentSuggestion extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PhoneCategory newModelQuery()
 * @method static Builder|PhoneCategory newQuery()
 * @method static Builder|PhoneCategory query()
 * @method static Builder|PhoneCategory whereCreatedAt($value)
 * @method static Builder|PhoneCategory whereId($value)
 * @method static Builder|PhoneCategory whereName($value)
 * @method static Builder|PhoneCategory whereType($value)
 * @method static Builder|PhoneCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class PhoneCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $owner_contact_id
 * @property int $lead_user_id
 * @property int $manager_contact_id
 * @property int $invoice_contact_id
 * @property int $project_category_id
 * @property int $parent_project_id
 * @property int $is_archived
 * @property string $hourly
 * @property string $budget_hours
 * @property string $budget_costs
 * @property string $budget_period
 * @property string|null $begin_on
 * @property string|null $end_on
 * @property string $website
 * @property string $note
 * @property string|null $avatar
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProjectCategory|null $category
 * @property-read User|null $lead
 * @property-read Contact|null $owner
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereAvatar($value)
 * @method static Builder|Project whereBeginOn($value)
 * @method static Builder|Project whereBudgetCosts($value)
 * @method static Builder|Project whereBudgetHours($value)
 * @method static Builder|Project whereBudgetPeriod($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereDeletedAt($value)
 * @method static Builder|Project whereEndOn($value)
 * @method static Builder|Project whereHourly($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereInvoiceContactId($value)
 * @method static Builder|Project whereIsArchived($value)
 * @method static Builder|Project whereLeadUserId($value)
 * @method static Builder|Project whereManagerContactId($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project whereNote($value)
 * @method static Builder|Project whereOwnerContactId($value)
 * @method static Builder|Project whereParentProjectId($value)
 * @method static Builder|Project whereProjectCategoryId($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereWebsite($value)
 * @mixin Eloquent
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $color
 * @property string|null $icon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProjectCategory newModelQuery()
 * @method static Builder|ProjectCategory newQuery()
 * @method static Builder|ProjectCategory query()
 * @method static Builder|ProjectCategory whereColor($value)
 * @method static Builder|ProjectCategory whereCreatedAt($value)
 * @method static Builder|ProjectCategory whereIcon($value)
 * @method static Builder|ProjectCategory whereId($value)
 * @method static Builder|ProjectCategory whereName($value)
 * @method static Builder|ProjectCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class ProjectCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $receipts_ref
 * @property string $reference
 * @property int $receipt_category_id
 * @property int $contact_id
 * @property string $issuedAt
 * @property int $tax_rate
 * @property float $amount
 * @property string $currency_code
 * @property float $exchange_rate
 * @property float $gross
 * @property float $net
 * @property float $tax
 * @property string $title
 * @property string $pdf_file
 * @property string $export_file_name
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Receipt newModelQuery()
 * @method static Builder|Receipt newQuery()
 * @method static Builder|Receipt query()
 * @method static Builder|Receipt whereAmount($value)
 * @method static Builder|Receipt whereContactId($value)
 * @method static Builder|Receipt whereCreatedAt($value)
 * @method static Builder|Receipt whereCurrencyCode($value)
 * @method static Builder|Receipt whereExchangeRate($value)
 * @method static Builder|Receipt whereExportFileName($value)
 * @method static Builder|Receipt whereGross($value)
 * @method static Builder|Receipt whereId($value)
 * @method static Builder|Receipt whereIssuedAt($value)
 * @method static Builder|Receipt whereNet($value)
 * @method static Builder|Receipt wherePdfFile($value)
 * @method static Builder|Receipt whereReceiptCategoryId($value)
 * @method static Builder|Receipt whereReceiptsRef($value)
 * @method static Builder|Receipt whereReference($value)
 * @method static Builder|Receipt whereTax($value)
 * @method static Builder|Receipt whereTaxRate($value)
 * @method static Builder|Receipt whereText($value)
 * @method static Builder|Receipt whereTitle($value)
 * @method static Builder|Receipt whereUpdatedAt($value)
 * @property string $issued_on
 * @property string|null $tax_code_number
 * @method static Builder|Receipt whereIssuedOn($value)
 * @method static Builder|Receipt whereTaxCodeNumber($value)
 * @property string $type
 * @property int|null $document_number
 * @property int $year
 * @property float $amount_to_pay
 * @property string|null $text_md5
 * @property int $is_locked
 * @property string|null $note
 * @property-read ReceiptCategory|null $category
 * @property-read Contact|null $contact
 * @property-read string $real_document_number
 * @method static Builder|Receipt whereAmountToPay($value)
 * @method static Builder|Receipt whereDocumentNumber($value)
 * @method static Builder|Receipt whereIsLocked($value)
 * @method static Builder|Receipt whereNote($value)
 * @method static Builder|Receipt whereTextMd5($value)
 * @method static Builder|Receipt whereType($value)
 * @method static Builder|Receipt whereYear($value)
 * @mixin Eloquent
 * @property-read \App\Models\BookkeepingBooking|null $booking
 */
	class Receipt extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $receipts_ref
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereReceiptsRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereUpdatedAt($value)
 * @property string $type
 * @property int $is_private
 * @property int $outturn_account_id
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereOutturnAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereType($value)
 * @mixin \Eloquent
 */
	class ReceiptCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $gender
 * @property int $is_hidden
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Salutation newModelQuery()
 * @method static Builder|Salutation newQuery()
 * @method static Builder|Salutation query()
 * @method static Builder|Salutation whereCreatedAt($value)
 * @method static Builder|Salutation whereGender($value)
 * @method static Builder|Salutation whereId($value)
 * @method static Builder|Salutation whereIsHidden($value)
 * @method static Builder|Salutation whereName($value)
 * @method static Builder|Salutation whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Salutation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $invoice_text
 * @property string $value
 * @property int $needs_vat_id
 * @property int $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Tax newModelQuery()
 * @method static Builder|Tax newQuery()
 * @method static Builder|Tax query()
 * @method static Builder|Tax whereCreatedAt($value)
 * @method static Builder|Tax whereId($value)
 * @method static Builder|Tax whereInvoiceText($value)
 * @method static Builder|Tax whereIsDefault($value)
 * @method static Builder|Tax whereName($value)
 * @method static Builder|Tax whereNeedsVatId($value)
 * @method static Builder|Tax whereUpdatedAt($value)
 * @method static Builder|Tax whereValue($value)
 * @property int $account_input_tax
 * @property int $account_vat
 * @property int $tax_code_number
 * @method static Builder|Tax whereAccountInputTax($value)
 * @method static Builder|Tax whereAccountVat($value)
 * @method static Builder|Tax whereTaxCodeNumber($value)
 * @property int $is_bidirectional
 * @method static Builder|Tax whereIsBidirectional($value)
 * @property int $legacy_id
 * @method static Builder|Tax whereLegacyId($value)
 * @mixin Eloquent
 */
	class Tax extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $time_category_id
 * @property int $subproject_id
 * @property int $task_id
 * @property int $user_id
 * @property int $invoice_id
 * @property string $note
 * @property string|null $begin_at
 * @property string|null $end_at
 * @property int $is_locked
 * @property int $is_billable
 * @property int $is_timer
 * @property int $minutes
 * @property string|null $dob
 * @property string|null $deleted_at
 * @property string|null $ping_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Time newModelQuery()
 * @method static Builder|Time newQuery()
 * @method static Builder|Time query()
 * @method static Builder|Time whereBeginAt($value)
 * @method static Builder|Time whereCreatedAt($value)
 * @method static Builder|Time whereDeletedAt($value)
 * @method static Builder|Time whereDob($value)
 * @method static Builder|Time whereEndAt($value)
 * @method static Builder|Time whereId($value)
 * @method static Builder|Time whereInvoiceId($value)
 * @method static Builder|Time whereIsBillable($value)
 * @method static Builder|Time whereIsLocked($value)
 * @method static Builder|Time whereIsTimer($value)
 * @method static Builder|Time whereMinutes($value)
 * @method static Builder|Time whereNote($value)
 * @method static Builder|Time wherePingAt($value)
 * @method static Builder|Time whereProjectId($value)
 * @method static Builder|Time whereSubprojectId($value)
 * @method static Builder|Time whereTaskId($value)
 * @method static Builder|Time whereTimeCategoryId($value)
 * @method static Builder|Time whereUpdatedAt($value)
 * @method static Builder|Time whereUserId($value)
 * @property-read TimeCategory|null $category
 * @property-read Project|null $project
 * @property-read User|null $user
 * @method static Builder|Time withMinutes()
 * @method static Builder|Time byWeekOfYear(int $week, int $year)
 * @method static Builder|Time maxDuration($date)
 * @method static Builder|Time view($view)
 * @property int $legacy_id
 * @property int $legacy_invoice_id
 * @method static Builder|Time whereLegacyId($value)
 * @method static Builder|Time whereLegacyInvoiceId($value)
 * @mixin Eloquent
 */
	class Time extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $pos
 * @property int $is_default
 * @property string $hourly
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TimeCategory newModelQuery()
 * @method static Builder|TimeCategory newQuery()
 * @method static Builder|TimeCategory query()
 * @method static Builder|TimeCategory whereCreatedAt($value)
 * @method static Builder|TimeCategory whereHourly($value)
 * @method static Builder|TimeCategory whereId($value)
 * @method static Builder|TimeCategory whereIsDefault($value)
 * @method static Builder|TimeCategory whereName($value)
 * @method static Builder|TimeCategory wherePos($value)
 * @method static Builder|TimeCategory whereShortName($value)
 * @method static Builder|TimeCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class TimeCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $correspondence_salutation_male
 * @property string $correspondence_salutation_female
 * @property string $correspondence_salutation_other
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Title newModelQuery()
 * @method static Builder|Title newQuery()
 * @method static Builder|Title query()
 * @method static Builder|Title whereCorrespondenceSalutationFemale($value)
 * @method static Builder|Title whereCorrespondenceSalutationMale($value)
 * @method static Builder|Title whereCorrespondenceSalutationOther($value)
 * @method static Builder|Title whereCreatedAt($value)
 * @method static Builder|Title whereId($value)
 * @method static Builder|Title whereName($value)
 * @method static Builder|Title whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class Title extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $mm_ref
 * @property int $contact_id
 * @property int $bank_account_id
 * @property Carbon $valued_on
 * @property Carbon|null $booked_on
 * @property string|null $comment
 * @property string $currency
 * @property string|null $booking_key
 * @property string|null $bank_code
 * @property string|null $account_number
 * @property string $name
 * @property string|null $purpose
 * @property float $amount
 * @property float $amount_EUR
 * @property int $is_private
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $prefix
 * @property int|null $document_number
 * @property int $year
 * @property-read BankAccount|null $bank_account
 * @property-read string $real_document_number
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAccountNumber($value)
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereAmountEUR($value)
 * @method static Builder|Transaction whereBankAccountId($value)
 * @method static Builder|Transaction whereBankCode($value)
 * @method static Builder|Transaction whereBookedOn($value)
 * @method static Builder|Transaction whereBookingKey($value)
 * @method static Builder|Transaction whereComment($value)
 * @method static Builder|Transaction whereContactId($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereCurrency($value)
 * @method static Builder|Transaction whereDocumentNumber($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereIsPrivate($value)
 * @method static Builder|Transaction whereMmRef($value)
 * @method static Builder|Transaction whereName($value)
 * @method static Builder|Transaction wherePrefix($value)
 * @method static Builder|Transaction wherePurpose($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereValuedOn($value)
 * @method static Builder|Transaction whereYear($value)
 * @property string|null $booking_text
 * @property string|null $type
 * @property string|null $return_reason
 * @property string|null $transaction_code
 * @property string|null $end_to_end_reference
 * @property string|null $mandate_reference
 * @property string|null $batch_reference
 * @property string|null $primanota_number
 * @method static Builder|Transaction whereBatchReference($value)
 * @method static Builder|Transaction whereBookingText($value)
 * @method static Builder|Transaction whereEndToEndReference($value)
 * @method static Builder|Transaction whereMandateReference($value)
 * @method static Builder|Transaction wherePrimanotaNumber($value)
 * @method static Builder|Transaction whereReturnReason($value)
 * @method static Builder|Transaction whereTransactionCode($value)
 * @method static Builder|Transaction whereType($value)
 * @property-read Contact|null $contact
 * @mixin Eloquent
 * @property-read \App\Models\BookkeepingBooking|null $booking
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $search_field
 * @property string $search_value
 * @property string $set_field
 * @property string $set_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereSearchField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereSearchValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereSetField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereSetValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TransactionRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class TransactionRule extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $first_name
 * @property string|null $avatar_url
 * @property bool $is_admin
 * @property-read string $full_name
 * @property-read string $initials
 * @property-read string $reverse_full_name
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatarUrl($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsAdmin($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\SushiModels{
/**
 * 
 *
 * @property int $id
 * @property int|null $contact_id
 * @property int|null $account_category_id
 * @property int|null $account_id
 * @property string|null $vat_id
 * @property int|null $is_dunning_block
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $invoice_contact_id
 * @property string|null $ref
 * @property int|null $default_tax_id
 * @property int|null $price_per_hour
 * @property int|null $payment_deadline_id
 * @property int|null $invoice_shipment_id
 * @property string|null $debtor_id
 * @property string|null $creditor_id
 * @property string|null $standard_account_id
 * @method static Builder|LegacyAccount newModelQuery()
 * @method static Builder|LegacyAccount newQuery()
 * @method static Builder|LegacyAccount query()
 * @method static Builder|LegacyAccount whereAccountCategoryId($value)
 * @method static Builder|LegacyAccount whereAccountId($value)
 * @method static Builder|LegacyAccount whereContactId($value)
 * @method static Builder|LegacyAccount whereCreatedAt($value)
 * @method static Builder|LegacyAccount whereCreditorId($value)
 * @method static Builder|LegacyAccount whereDebtorId($value)
 * @method static Builder|LegacyAccount whereDefaultTaxId($value)
 * @method static Builder|LegacyAccount whereId($value)
 * @method static Builder|LegacyAccount whereInvoiceContactId($value)
 * @method static Builder|LegacyAccount whereInvoiceShipmentId($value)
 * @method static Builder|LegacyAccount whereIsDunningBlock($value)
 * @method static Builder|LegacyAccount wherePaymentDeadlineId($value)
 * @method static Builder|LegacyAccount wherePricePerHour($value)
 * @method static Builder|LegacyAccount whereRef($value)
 * @method static Builder|LegacyAccount whereStandardAccountId($value)
 * @method static Builder|LegacyAccount whereUpdatedAt($value)
 * @method static Builder|LegacyAccount whereVatId($value)
 * @mixin Eloquent
 */
	class LegacyAccount extends \Eloquent {}
}

namespace App\SushiModels{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $account_id
 * @property int|null $project_id
 * @property int|null $invoice_number
 * @property string|null $issued_on
 * @property string|null $due_on
 * @property int|null $amount
 * @property float|null $tax
 * @property int|null $dunning_block
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $is_draft
 * @property int|null $is_dept_order
 * @property int|null $dunning_level
 * @property int|null $type
 * @property string|null $service_provision
 * @property string|null $dept_order_on
 * @property string|null $dept_order_file
 * @property string|null $mandate_reference
 * @property string|null $contact_id
 * @property string|null $bank_account_id
 * @property string|null $vat_id
 * @property string|null $sent_at
 * @property string|null $address
 * @property string|null $template
 * @property int|null $note_paper_id
 * @property string|null $sent_by
 * @property string|null $note
 * @property string|null $last_reminder_on
 * @property string|null $reminder_due_on
 * @property int|null $payment_deadline_id
 * @method static Builder|LegacyInvoice newModelQuery()
 * @method static Builder|LegacyInvoice newQuery()
 * @method static Builder|LegacyInvoice query()
 * @method static Builder|LegacyInvoice whereAccountId($value)
 * @method static Builder|LegacyInvoice whereAddress($value)
 * @method static Builder|LegacyInvoice whereAmount($value)
 * @method static Builder|LegacyInvoice whereBankAccountId($value)
 * @method static Builder|LegacyInvoice whereContactId($value)
 * @method static Builder|LegacyInvoice whereCreatedAt($value)
 * @method static Builder|LegacyInvoice whereDeptOrderFile($value)
 * @method static Builder|LegacyInvoice whereDeptOrderOn($value)
 * @method static Builder|LegacyInvoice whereDueOn($value)
 * @method static Builder|LegacyInvoice whereDunningBlock($value)
 * @method static Builder|LegacyInvoice whereDunningLevel($value)
 * @method static Builder|LegacyInvoice whereId($value)
 * @method static Builder|LegacyInvoice whereInvoiceNumber($value)
 * @method static Builder|LegacyInvoice whereIsDeptOrder($value)
 * @method static Builder|LegacyInvoice whereIsDraft($value)
 * @method static Builder|LegacyInvoice whereIssuedOn($value)
 * @method static Builder|LegacyInvoice whereLastReminderOn($value)
 * @method static Builder|LegacyInvoice whereMandateReference($value)
 * @method static Builder|LegacyInvoice whereNote($value)
 * @method static Builder|LegacyInvoice whereNotePaperId($value)
 * @method static Builder|LegacyInvoice wherePaymentDeadlineId($value)
 * @method static Builder|LegacyInvoice whereProjectId($value)
 * @method static Builder|LegacyInvoice whereReminderDueOn($value)
 * @method static Builder|LegacyInvoice whereSentAt($value)
 * @method static Builder|LegacyInvoice whereSentBy($value)
 * @method static Builder|LegacyInvoice whereServiceProvision($value)
 * @method static Builder|LegacyInvoice whereTax($value)
 * @method static Builder|LegacyInvoice whereTemplate($value)
 * @method static Builder|LegacyInvoice whereType($value)
 * @method static Builder|LegacyInvoice whereUpdatedAt($value)
 * @method static Builder|LegacyInvoice whereUserId($value)
 * @method static Builder|LegacyInvoice whereVatId($value)
 * @mixin Eloquent
 */
	class LegacyInvoice extends \Eloquent {}
}

namespace App\SushiModels{
/**
 * 
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property int|null $quantity
 * @property string|null $unit
 * @property string|null $text
 * @property int|null $price
 * @property int|null $amount
 * @property int|null $tax
 * @property int|null $type
 * @property string|null $tax_id
 * @property int|null $pos
 * @method static Builder|LegacyInvoiceLine newModelQuery()
 * @method static Builder|LegacyInvoiceLine newQuery()
 * @method static Builder|LegacyInvoiceLine query()
 * @method static Builder|LegacyInvoiceLine whereAmount($value)
 * @method static Builder|LegacyInvoiceLine whereId($value)
 * @method static Builder|LegacyInvoiceLine whereInvoiceId($value)
 * @method static Builder|LegacyInvoiceLine wherePos($value)
 * @method static Builder|LegacyInvoiceLine wherePrice($value)
 * @method static Builder|LegacyInvoiceLine whereQuantity($value)
 * @method static Builder|LegacyInvoiceLine whereTax($value)
 * @method static Builder|LegacyInvoiceLine whereTaxId($value)
 * @method static Builder|LegacyInvoiceLine whereText($value)
 * @method static Builder|LegacyInvoiceLine whereType($value)
 * @method static Builder|LegacyInvoiceLine whereUnit($value)
 * @mixin Eloquent
 */
	class LegacyInvoiceLine extends \Eloquent {}
}

namespace App\SushiModels{
/**
 * 
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $mite_id
 * @property int|null $account_id
 * @property string|null $invoice_name
 * @property int|null $is_archived
 * @property string|null $project_category_id
 * @property string|null $description
 * @property int|null $parent_id
 * @property string|null $price_per_hour
 * @method static Builder|LegacyProject newModelQuery()
 * @method static Builder|LegacyProject newQuery()
 * @method static Builder|LegacyProject query()
 * @method static Builder|LegacyProject whereAccountId($value)
 * @method static Builder|LegacyProject whereCreatedAt($value)
 * @method static Builder|LegacyProject whereCustomerId($value)
 * @method static Builder|LegacyProject whereDescription($value)
 * @method static Builder|LegacyProject whereId($value)
 * @method static Builder|LegacyProject whereInvoiceName($value)
 * @method static Builder|LegacyProject whereIsArchived($value)
 * @method static Builder|LegacyProject whereMiteId($value)
 * @method static Builder|LegacyProject whereName($value)
 * @method static Builder|LegacyProject whereParentId($value)
 * @method static Builder|LegacyProject wherePricePerHour($value)
 * @method static Builder|LegacyProject whereProjectCategoryId($value)
 * @method static Builder|LegacyProject whereUpdatedAt($value)
 * @method static Builder|LegacyProject whereUserId($value)
 * @mixin Eloquent
 */
	class LegacyProject extends \Eloquent {}
}

namespace App\SushiModels{
/**
 * 
 *
 * @property int $id
 * @property string|null $mite_id
 * @property int|null $invoice_id
 * @property int|null $project_id
 * @property string|null $date
 * @property string|null $begin
 * @property string|null $end
 * @property int|null $service_id
 * @property int|null $user_id
 * @property int|null $minutes
 * @property string|null $note
 * @property string|null $created_at
 * @property string|null $updated_ad
 * @property int|null $is_locked
 * @property string|null $task
 * @property string|null $subproject_id
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereMiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereSubprojectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereUpdatedAd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereUserId($value)
 * @mixin \Eloquent
 */
	class LegacyTime extends \Eloquent {}
}

