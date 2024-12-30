<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use App\Models\FranchiseRequest;
use App\Models\FranchiseImage;
use App\Models\FranchiseRequestHistory;
use App\Models\SpaceRequired;

use App\Models\EquipmentCost;
use App\Models\TrainingPeriod;
use App\Models\ContractPeriod;
use App\Models\FranchiseCharacteristic;


class FranchiseController extends Controller
{
  public function index()
  {
    $franchises = Franchise::with([
      'category',
      'country',
      'spaceRequired' => fn($q) => $q->with('unit'),
      'trainingPeriod' => fn($q) => $q->with('unit'),
      'franchiseCharacteristic',
      'contractPeriod' => fn($q) => $q->with('unit'),
      'equipmentCost' => fn($q) => $q->with('unit'),
      'addedBy'
    ])->paginate();

    return response()->json([
      'status' => 200,
      'data' => $franchises,
    ], 200);
  }

  public function filter(Request $request)
  {
    $country = $request->query('country');
    $category = $request->query('category');

    $with = [
      'category',
      'country',
      'spaceRequired' => fn($q) => $q->with('unit'),
      'trainingPeriod' => fn($q) => $q->with('unit'),
      'franchiseCharacteristic',
      'contractPeriod' => fn($q) => $q->with('unit'),
      'equipmentCost' => fn($q) => $q->with('unit'),
      'addedBy'
    ];

    $franchises = Franchise::with($with)->paginate();

    if (isset($country)) {
      $franchises = Franchise::with($with)->where('country_id', $country)->paginate();
    }

    if (isset($category)) {
      $franchises = Franchise::with($with)->where('category_id', $category)->paginate();
    }

    if (isset($category) && isset($country)) {
      $franchises = Franchise::with($with)
        ->where('country_id', $country)
        ->where('category_id', $category)
        ->paginate();
    }

    return response()->json([
      'status' => 200,
      'data' => $franchises,
    ], 200);
  }

  public function show($id)
  {
    $franchise = Franchise::find($id)->with([
      'category',
      'country',
      'spaceRequired' => fn($q) => $q->with('unit'),
      'trainingPeriod' => fn($q) => $q->with('unit'),
      'franchiseCharacteristic',
      'contractPeriod' => fn($q) => $q->with('unit'),
      'equipmentCost' => fn($q) => $q->with('unit'),
      'addedBy'
    ])->first();

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

  public function showRequests($id)
  {
    $requests = FranchiseRequest::where('franchise_id', $id)
      ->with('user')
      ->get();

    return response()->json([
      'status' => 200,
      'data' => $requests,
    ], 200);
  }

  public function showRequestHistory($id, $history)
  {
    $requests = FranchiseRequestHistory::where('franchise_request_id', $history)
      ->with('request', 'changedBy')
      ->get();

    return response()->json([
      'status' => 200,
      'data' => $requests,
    ], 200);
  }

  public function showImages($id)
  {
    $images = FranchiseImage::where('franchise_id', $id)
      ->get();

    return response()->json([
      'status' => 200,
      'data' => $images,
    ], 200);
  }

  public function createImage(Request $request, $id)
  {
    $request->validate([
      'image_url' => 'required|string|url',
    ]);

    $image = FranchiseImage::create([
      'franchise_id' => $id,
      'image_url' => $request->image_url,
    ]);

    return response()->json([
      'status' => 200,
      'message' => 'تم رفع الصورة بنجاح',
    ], 200);
  }

  public function updateImage(Request $request, $id, $imageId)
  {
    $request->validate([
      'image_url' => 'required|string|url',
    ]);

    $image = FranchiseImage::find($imageId);
    $image->update([
      'image_url' => $request->image_url,
    ]);

    return response()->json([
      'status' => 200,
      'message' => 'تم تعديل الصورة بنجاح',
    ], 200);
  }

  public function deleteImage(Request $request, $id, $imageId)
  {
    $request->validate([
      'image_url' => 'required|string|url',
    ]);

    $image = FranchiseImage::find($imageId);
    $image->delete();

    return response()->json([
      'status' => 200,
      'message' => 'تم حذف الصورة بنجاح',
    ], 200);
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string',
      'description' => 'nullable|string',
      'category_id' => 'required|exists:categories,id',
      'country_id' => 'required|exists:countries,id',
      'image_url' => 'nullable|string',
      'number_of_branches' => 'required|integer',
      'number_of_labors' => 'required|integer',
      'establish_year' => 'required|integer',
      'center_office' => 'required|string',
      'added_by' => 'required|exists:users,id',

      'space_required.unit_id' => 'required|exists:units,id',
      'space_required.value' => 'required|numeric|gt:0',

      'equipment_cost.unit_id' => 'required|exists:units,id',
      'equipment_cost.value' => 'required|numeric|gt:0',

      'training_period.unit_id' => 'required|exists:units,id',
      'training_period.value' => 'required|numeric|gt:0',

      'contract_period.unit_id' => 'required|exists:units,id',
      'contract_period.value' => 'required|numeric|gt:0',

      'franchise_characteristics.franchise_fees' => 'required|numeric|gt:0',
      'franchise_characteristics.royalty_fees' => 'required|numeric|gt:0',
      'franchise_characteristics.marketing_fees' => 'required|numeric|gt:0',
      'franchise_characteristics.investments_cost' => 'required|numeric|gt:0',

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 422,
        'message' => 'Validation errors.',
        'errors' => $validator->errors(),
      ], 422);
    }

    $space = SpaceRequired::create($request->space_required);
    $equipment = EquipmentCost::create($request->equipment_cost);
    $training = TrainingPeriod::create($request->training_period);
    $contract = ContractPeriod::create($request->contract_period);
    $franchiseCharacteristics = FranchiseCharacteristic::create($request->franchise_characteristics);

    $user = Auth::user();

    $franchise = Franchise::create([
      'name' => $request->name,
      'description' => $request->description,
      'category_id' => $request->category_id,
      'country_id' => $request->country_id,
      'image_url' => $request->image_url,
      'number_of_branches' => $request->number_of_branches,
      'number_of_labors' => $request->number_of_labors,
      'establish_year' => $request->establish_year,
      'center_office' => $request->center_office,

      'added_by' => $user->id,
      'training_period_id' => $training->id,
      'franchise_characteristics_id' => $franchiseCharacteristics->id,
      'contract_period_id' => $contract->id,
      'space_required_id' => $space->id,
      'equipment_cost_id' => $equipment->id,
    ]);

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
      'category_id' => 'nullable|exists:categories,id',
      'country_id' => 'nullable|exists:countries,id',
      'image_url' => 'nullable|string',
      'number_of_branches' => 'nullable|integer',
      'number_of_labors' => 'nullable|integer',
      'establish_year' => 'nullable|integer',
      'center_office' => 'nullable|string',
      'added_by' => 'nullable|exists:users,id',

      'space_required.unit_id' => 'nullable|exists:units,id',
      'space_required.value' => 'nullable|numeric|gt:0',

      'equipment_cost.unit_id' => 'nullable|exists:units,id',
      'equipment_cost.value' => 'nullable|numeric|gt:0',

      'training_period.unit_id' => 'nullable|exists:units,id',
      'training_period.value' => 'nullable|numeric|gt:0',

      'contract_period.unit_id' => 'nullable|exists:units,id',
      'contract_period.value' => 'nullable|numeric|gt:0',

      'franchise_characteristics.franchise_fees' => 'nullable|numeric|gt:0',
      'franchise_characteristics.royalty_fees' => 'nullable|numeric|gt:0',
      'franchise_characteristics.marketing_fees' => 'nullable|numeric|gt:0',
      'franchise_characteristics.investments_cost' => 'nullable|numeric|gt:0',

    ]);

    if ($validator->fails()) {
      return response()->json([
        'status' => 422,
        'message' => 'Validation errors.',
        'errors' => $validator->errors(),
      ], 422);
    }

    $space = SpaceRequired::create($request->space_required);
    $equipment = EquipmentCost::create($request->equipment_cost);
    $training = TrainingPeriod::create($request->training_period);
    $contract = ContractPeriod::create($request->contract_period);
    $franchiseCharacteristics = FranchiseCharacteristic::create($request->franchise_characteristics);

    $franchise = Franchise::where('id', $id)->update([
      'name' => $request->name,
      'description' => $request->description,
      'category_id' => $request->category_id,
      'country_id' => $request->country_id,
      'image_url' => $request->image_url,
      'number_of_branches' => $request->number_of_branches,
      'number_of_labors' => $request->number_of_labors,
      'establish_year' => $request->establish_year,
      'center_office' => $request->center_office,

      'training_period_id' => $training->id,
      'franchise_characteristics_id' => $franchiseCharacteristics->id,
      'contract_period_id' => $contract->id,
      'space_required_id' => $space->id,
      'equipment_cost_id' => $equipment->id,
    ]);

    return response()->json([
      'status' => 201,
      'message' => 'تم تحديث الفرنشايز بنجاح',
      'data' => $franchise,
    ], 201);
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
