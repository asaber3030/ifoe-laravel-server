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
