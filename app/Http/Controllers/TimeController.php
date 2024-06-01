<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;
use App\Http\Resources\TimeCollection;

class TimeController extends Controller
{
  public function index()
  {
    return new TimeCollection(Time::query()
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

    $contact = Time::create($validated);
    return response()->json([
      'contact' => $contact
    ]);
  }

  public function show(Time $time)
  {

    $time->load('company')->load('title');

    return response()->json([
      'time' => $time
    ]);
  }

  public function update(Request $request, Time $time)
  {
    $validated = $request->validate([
      'name' => 'required'
    ]);

    $time->update($validated);

    return response()->json([
      'time' => $time
    ]);
  }

  public function destroy(Time $time)
  {
    //
  }
}
