<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Franchise;

class FranchiseController extends Controller
{
  public function index()
  {
    $franchises = Franchise::with(
      'category',
      'country',
      'spaceRequired',
      'trainingPeriod',
      'franchiseCharacteristic',
      'contractPeriod',
      'addedBy'
    )->get();

    return response()->json([
      'status' => 200,
      'data' => $franchises,
    ], 200);
  }

  public function show($id)
  {
    $franchise = Franchise::find($id)->with(
      'category',
      'country',
      'spaceRequired',
      'trainingPeriod',
      'franchiseCharacteristic',
      'contractPeriod',
      'addedBy'
    )->first();

    if (!$franchise) {
      return response()->json([
        'status' => 404,
        'message' => 'الفرنشايز غير موجود',
      ], 404);
    }

    return response()->json([
      'status' => 200,
      'message' => 'تم العثور على الفرنشايز',
      'data' => $franchise,
    ], 200);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'description' => 'nullable|string',
      'equipment_cost_id' => 'required|exists:equipment_costs,id',
      'category_id' => 'required|exists:categories,id',
      'country_id' => 'required|exists:countries,id',
      'image_url' => 'nullable|string',
      'number_of_branches' => 'required|integer',
      'space_required_id' => 'required|exists:space_required,id',
      'number_of_labors' => 'required|integer',
      'training_period_id' => 'required|exists:training_periods,id',
      'establish_year' => 'required|integer',
      'center_office' => 'required|string',
      'franchise_characteristics_id' => 'required|exists:franchise_characteristics,id',
      'contract_period_id' => 'required|exists:contract_periods,id',
      'added_by' => 'required|exists:users,id'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 422,
        'message' => 'Validation errors.',
        'errors' => $validator->errors(),
      ], 422);
    }

    $franchise = Franchise::create($request->all());

    return response()->json([
      'status' => 201,
      'message' => 'تم إنشاء الفرنشايز بنجاح',
      'data' => $franchise,
    ], 201);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'nullable|string',
      'description' => 'nullable|string',
      'equipment_cost_id' => 'nullable|exists:equipment_costs,id',
      'category_id' => 'nullable|exists:categories,id',
      'country_id' => 'nullable|exists:countries,id',
      'image_url' => 'nullable|string',
      'number_of_branches' => 'nullable|integer',
      'space_required_id' => 'nullable|exists:space_required,id',
      'number_of_labors' => 'nullable|integer',
      'training_period_id' => 'nullable|exists:training_periods,id',
      'establish_year' => 'nullable|integer',
      'center_office' => 'nullable|string',
      'franchise_characteristics_id' => 'nullable|exists:franchise_characteristics,id',
      'contract_period_id' => 'nullable|exists:contract_periods,id',
      'added_by' => 'nullable|exists:users,id'
    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 422,
        'message' => 'Validation errors.',
        'errors' => $validator->errors(),
      ], 422);
    }

    $franchise = Franchise::find($id);

    if (!$franchise) {
      return response()->json([
        'status' => 404,
        'message' => 'الفرنشايز غير موجود',
      ], 404);
    }

    $franchise->update($request->all());

    return response()->json([
      'status' => 200,
      'message' => 'تم تحديث الفرنشايز بنجاح',
      'data' => $franchise,
    ], 200);
  }

  public function destroy($id)
  {
    $franchise = Franchise::find($id);

    if (!$franchise) {
      return response()->json([
        'status' => 404,
        'message' => 'الفرنشايز غير موجود',
      ], 404);
    }

    $franchise->delete();

    return response()->json([
      'status' => 200,
      'message' => 'تم حذف الفرنشايز بنجاح',
    ], 200);
  }
}
