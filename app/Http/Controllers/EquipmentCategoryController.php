<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\EquipmentCategoryResource;
use App\Http\Resources\EquipmentCategoryCollection;

use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new EquipmentCategoryCollection(EquipmentCategory::orderBy('name')->with('parent')->paginate($this->recordsPerPage));
      // return new InventoryGroupCollection(InventoryGroup::orderBy('name')->with('segment')->paginate($this->recordsPerPage));

    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required',
        'parent_id' =>'nullable|numeric',
        'inventory_groups' => 'nullable|array'
      ]);

      $equipmentCategory = EquipmentCategory::create($validated);
      $equipmentCategory->inventory_groups()->sync($validated['inventory_groups']);

      return response()->json([
        'category' => $equipmentCategory
      ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentCategory $equipmentCategory)
    {
      return new EquipmentCategoryResource($equipmentCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentCategory $equipmentCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EquipmentCategory $equipmentCategory)
    {
        $validated = $request->validate([
          'name' =>'required',
          'parent_id' =>'nullable|numeric',
          'inventory_groups' => 'nullable|array'
        ]);

        $equipmentCategory->update($validated);
        $equipmentCategory->inventory_groups()->sync($validated['inventory_groups']);

        dump($equipmentCategory);

        return response()->json([
          'category' => $equipmentCategory
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentCategory $equipmentCategory)
    {
        //
    }
}
