<?php

namespace App\Http\Controllers;

use App\Models\PaymentDeadline;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new DepartmentCollection(PaymentDeadline::orderBy('name')->paginate($this->recordsPerPage));
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $department = PaymentDeadline::create($validated);
      return response()->json([
        'department' => $department
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentDeadline $department)
    {
      return response()->json([
        'department' => $department
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentDeadline $department)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $department->update($validated);

      return response()->json([
        'department' => $department
      ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentDeadline $department)
    {
        //
    }
}
