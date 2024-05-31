<?php

namespace App\Http\Controllers;

use App\Models\InventoryGroup;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryGroupCollection;


class InventoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new InventoryGroupCollection(InventoryGroup::orderBy('name')->with('segment')->paginate($this->recordsPerPage));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required',
        'inventory_number_prefix' => 'required',
        'inventory_current_number' => 'nullable|numeric',
        'business_segment_id' => 'numeric'
      ]);

      $inventoryGroup = InventoryGroup::create($validated);
      return response()->json([
        'group' => $inventoryGroup
      ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryGroup $inventoryGroup)
    {
      return response()->json([
        'group' => $inventoryGroup
      ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryGroup $inventoryGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryGroup $inventoryGroup)
    {
      $validated = $request->validate([
        'name' => 'required',
        'inventory_number_prefix' => 'required',
        'inventory_current_number' => 'required',
        'business_segment_id' => 'numeric'
      ]);

      $inventoryGroup->update($validated);

      return response()->json([
        'group' => $inventoryGroup
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryGroup $inventoryGroup)
    {
        //
    }
}
