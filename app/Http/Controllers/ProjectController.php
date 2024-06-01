<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectCollection;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new ProjectCollection(Project::query()
        ->orderBy('name')
        ->with('owner')
        ->with('category')
        ->with('lead')
        ->paginate($this->recordsPerPage));
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $segment = EmailCategory::create($validated);
      return response()->json([
       'segment' => $segment
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailCategory $businessSegment)
    {
        return response()->json([
         'segment' => $businessSegment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailCategory $businessSegment)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $businessSegment->update($validated);

      return response()->json([
       'segment' => $businessSegment
      ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailCategory $businessSegment)
    {
        //
    }
}
