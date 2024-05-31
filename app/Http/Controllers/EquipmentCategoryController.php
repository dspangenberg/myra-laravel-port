<?php

namespace App\Http\Controllers;

use App\Models\PhoneCategory;
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
      return new EquipmentCategoryCollection(PhoneCategory::orderBy('name')->with('parent')->paginate($this->recordsPerPage));
      // return new InventoryGroupCollection(InventoryGroup::orderBy('name')->with('segment')->paginate($this->recordsPerPage));

    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' => 'required',
        'parent_id' =>'nullable|numeric',
        'inventory_groups' => 'nullable|array'
      ]);

      $equipmentCategory = PhoneCategory::create($validated);
      $equipmentCategory->inventory_groups()->sync($validated['inventory_groups']);

      return response()->json([
        'category' => $equipmentCategory
      ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PhoneCategory $equipmentCategory)
    {
      return new EquipmentCategoryResource($equipmentCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhoneCategory $equipmentCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhoneCategory $equipmentCategory)
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
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhoneCategory $equipmentCategory)
    {
        //
    }
}
