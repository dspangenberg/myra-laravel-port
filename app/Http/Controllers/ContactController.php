<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Resources\ContactCollection;

class ContactController extends Controller
{
  public function index()
  {
    return new ContactCollection(Contact::query()
      ->with('company')
      ->with('title')
      ->orderBy('name')
      ->paginate($this->recordsPerPage));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required'
    ]);

    $contact = Contact::create($validated);
    return response()->json([
      'contact' => $contact
    ]);
  }

  public function show(Contact $contact)
  {

    $contact->load('company')->load('title');

    return response()->json([
      'contact' => $contact
    ]);
  }

  public function update(Request $request, Contact $contact)
  {
    $validated = $request->validate([
      'name' => 'required'
    ]);

    $contact->update($validated);

    return response()->json([
      'contact' => $contact
    ]);
  }

  public function destroy(Contact $contact)
  {
    //
  }
}
