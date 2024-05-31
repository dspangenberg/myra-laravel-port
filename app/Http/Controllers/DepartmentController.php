<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new DepartmentCollection(Department::orderBy('name')->paginate($this->recordsPerPage));
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $department = Department::create($validated);
      return response()->json([
        'department' => $department
      ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
      return response()->json([
        'department' => $department
      ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $department->update($validated);

      return response()->json([
        'department' => $department
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
