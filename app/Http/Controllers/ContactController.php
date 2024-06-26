<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Models\AddressCategory;
use App\Models\Contact;
use App\Models\Country;
use App\Models\EmailCategory;
use App\Models\PaymentDeadline;
use App\Models\PhoneCategory;
use App\Models\Salutation;
use App\Models\Tax;
use App\Models\Title;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContact;


class ContactController extends Controller
{
    public function index()
    {
        return ContactResource::collection(Contact::query()
            ->with('company')
            ->with('title')
            ->orderBy('name')
            ->whereNull('is_archived')
            ->orWhere('is_archived', false)
            ->paginate($this->recordsPerPage)
        );
    }

    public function store(StoreContact $request)
    {
        $contact = Contact::create($request->validated());
        return new ContactResource($contact);
    }

    public function create()
    {
        $contact = new Contact();

        return ContactResource::make($contact)->additional([
            'salutations' => Salutation::all(),
            'titles' => Title::all(),
            'payment_deadlines' => PaymentDeadline::all(),
            'address_categories' => AddressCategory::all(),
            'email_categories' => EmailCategory::all(),
            'phone_categories' => PhoneCategory::all(),
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

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        //
    }
}
