<?php

namespace App\Http\Controllers;

use App\Models\PaymentDeadlineSeeder;
use Illuminate\Http\Request;
use App\Http\Resources\EmpowermentCollection;

class EmpowermentController extends Controller
{
    public function index()
    {
      return new EmpowermentCollection(PaymentDeadlineSeeder::orderBy('name')->paginate($this->recordsPerPage));
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        'name' =>'required'
      ]);

      $empowerment = PaymentDeadlineSeeder::create($validated);
      return response()->json([
        'empowerment' => $empowerment,
        'abbreviation' => 'nullable'
      ]);
    }

    public function show(PaymentDeadlineSeeder $empowerment)
    {
      return response()->json([
        'empowerment' => $empowerment
      ]);
    }


    public function update(Request $request, PaymentDeadlineSeeder $empowerment)
    {
      $validated = $request->validate([
        'name' =>'required',
        'abbreviation' => 'nullable'
      ]);

      $empowerment->update($validated);

      return response()->json([
        'empowerment' => $empowerment
      ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentDeadlineSeeder $empowerment)
    {
        //
    }
}
