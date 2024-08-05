<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContact;
use App\Http\Resources\ContactResource;
use App\Models\AddressCategory;
use App\Models\BookkeepingAccount;
use App\Models\Contact;
use App\Models\Country;
use App\Models\EmailCategory;
use App\Models\PaymentDeadline;
use App\Models\PhoneCategory;
use App\Models\Salutation;
use App\Models\Tax;
use App\Models\Title;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = QueryBuilder::for(Contact::class, $request)
            ->allowedFilters([
                AllowedFilter::scope('view'),
            ])
            ->select('*')
            ->with('company')
            ->with('title')
            ->orderBy('name')
            ->paginate($this->recordsPerPage, $request->get('page', 1));

        return ContactResource::collection($contacts);
    }

    public function store(StoreContact $request)
    {
        $contact = Contact::create($request->validated());

        return new ContactResource($contact);
    }

    public function create()
    {
        $contact = new Contact;

        return ContactResource::make($contact)->additional([
            'salutations' => Salutation::all(),
            'titles' => Title::all(),
            'payment_deadlines' => PaymentDeadline::all(),
            'address_categories' => AddressCategory::all(),
            'email_categories' => EmailCategory::all(),
            'bookkeeping_accounts' => BookkeepingAccount::all(),
            'taxes' => Tax::all(),
            'country' => Country::all(),
        ]);
    }

    public function edit(Contact $contact)
    {
        $contact->load('addresses');

        return ContactResource::make($contact)->additional([
            'salutations' => Salutation::all(),
            'titles' => Title::all(),
            'payment_deadlines' => PaymentDeadline::all(),
            'bookkeeping_accounts' => BookkeepingAccount::orderBy('account_number')->whereIn('type', ['r', 'e', 'n'])->get(),
            'address_categories' => AddressCategory::all(),
            'email_categories' => EmailCategory::all(),
            'phone_categories' => PhoneCategory::all(),
            'taxes' => Tax::all(),
            'country' => Country::all(),
        ]);
    }

    public function show(Contact $contact)
    {

        $contact
            ->load('company')
            ->load('title')
            ->load('salutation')
            ->load('payment_deadline')
            ->load('tax')
            ->load('contacts')
            ->load('addresses');

        return new ContactResource($contact);
    }

    public function update(StoreContact $request, Contact $contact)
    {
        $contact->update($request->validated());
        $contact->mails()->upsert($request->validated('mails'), 'email');

        dump($contact);

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        //
    }
}
