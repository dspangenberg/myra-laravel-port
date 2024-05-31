<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Http\Resources\ManufacturerCollection;



class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return new ManufacturerCollection(Manufacturer::orderBy('name')->paginate($this->recordsPerPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

      $validated = $request->validate([
        'name' => 'required'
      ]);

      $manufacturer = Manufacturer::create($validated);
      return response()->json([
        'manufacturer' => $manufacturer
      ]);
    }


    public function show(Manufacturer $manufacturer)
    {
      return response()->json([
        'manufacturer' => $manufacturer
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function update(Request $request, Manufacturer $manufacturer)
    {
      $validated = $request->validate([
        'name' => 'required',
      ]);

      $manufacturer->update($validated);

      return response()->json([
        'manufacturer' => $manufacturer
      ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        //
    }
}
