<?php

namespace App\Http\Controllers;

use App\Models\Filing;
use Illuminate\Http\Request;
use App\Http\Resources\FilingCollection;

class FilingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new FilingCollection(Filing::orderBy('name')->with('segment')->paginate($this->recordsPerPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' =>'required',
        'business_segment_id' =>'required'
      ]);

      $filing = Filing::create($validated);
      return response()->json([
        'filing' => $filing
      ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Filing $filing)
    {
      return response()->json([
        'filing' => $filing
      ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filing $filing)
    {
      $validated = $request->validate([
        'name' =>'required',
        'business_segment_id' =>'required'
      ]);

      $filing->update($validated);

      return response()->json([
        'filing' => $filing
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filing $filing)
    {
        //
    }
}
