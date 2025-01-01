<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
  public function index()
  {
    $units = Unit::orderBy('id', 'desc')->get();
    return response()->json([
      'status' => 200,
      'message' => 'تم جلب الوحدات بنجاح',
      'data' => $units
    ], 200);
  }

  public function show($id)
  {
    $unit = Unit::find($id);

    if ($unit) {
      return response()->json([
        'status' => 200,
        'message' => 'تم العثور على الوحدة',
        'data' => $unit
      ], 200);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'لم يتم العثور على الوحدة',
      ], 404);
    }
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);

    $unit = Unit::create([
      'name' => $request->name,
    ]);

    return response()->json([
      'status' => 201,
      'message' => 'تم إضافة الوحدة بنجاح',
      'data' => $unit
    ], 201);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);

    $unit = Unit::find($id);

    if ($unit) {
      $unit->update([
        'name' => $request->name,
      ]);

      return response()->json([
        'status' => 200,
        'message' => 'تم تحديث الوحدة بنجاح',
        'data' => $unit
      ], 200);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'لم يتم العثور على الوحدة',
      ], 404);
    }
  }

  public function destroy($id)
  {
    $unit = Unit::find($id);

    if ($unit) {
      $unit->delete();

      return response()->json([
        'status' => 200,
        'message' => 'تم حذف الوحدة بنجاح',
      ], 200);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'لم يتم العثور على الوحدة',
      ], 404);
    }
  }
}
