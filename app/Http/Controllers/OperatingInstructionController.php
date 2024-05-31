<?php

namespace App\Http\Controllers;

use App\Models\OperatingInstruction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\OperatingInstructionCollection;


class OperatingInstructionController extends Controller
{
  public function index()
  {
    return new OperatingInstructionCollection(OperatingInstruction::orderBy('name')->paginate($this->recordsPerPage));
  }

  public function show(OperatingInstruction $operating_instruction)
  {
      return response()->json([
        'instruction' => $operating_instruction
      ], 200);
  }

  public function update(Request $request, OperatingInstruction $operating_instruction)
  {

    $validated = $request->validate([
      'number' => ['required', Rule::unique('operating_instructions')->ignore($operating_instruction)],
      'name' => 'required',
    ]);

    $operating_instruction->update($validated);

    return response()->json([
      'instruction' => $operating_instruction
    ], 200);
  }



  public function store(Request $request)
  {

    $validated = $request->validate([
      'number' => 'required|unique:operating_instructions',
      'name' => 'required',
    ]);

    $operating_instruction = OperatingInstruction::create($validated);
    return response()->json([
      'instruction' => $operating_instruction
    ], 200);
  }
}
