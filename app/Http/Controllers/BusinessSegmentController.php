<?php

namespace App\Http\Controllers;

use App\Models\BusinessSegment;
use Illuminate\Http\Request;
use App\Http\Resources\BusinessSegmentCollection;

class BusinessSegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new BusinessSegmentCollection(BusinessSegment::orderBy('name')->paginate($this->recordsPerPage));
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $segment = BusinessSegment::create($validated);
      return response()->json([
       'segment' => $segment
      ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessSegment $businessSegment)
    {
        return response()->json([
         'segment' => $businessSegment
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessSegment $businessSegment)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $businessSegment->update($validated);

      return response()->json([
       'segment' => $businessSegment
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessSegment $businessSegment)
    {
        //
    }
}
