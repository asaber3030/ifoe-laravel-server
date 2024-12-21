<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
  public function index()
  {
    $role = Role::all();
    return response()->json([
      'status' => 200,
      'data' => $role
    ], 200);
  }

  public function show($id)
  {
    $role = Role::find($id);

    if ($role) {
      return response()->json([
        'status' => 200,
        'message' => 'تم العثور على الدور',
        'data' => $role
      ], 200);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'لم يتم العثور على الدور',
      ], 404);
    }
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);

    $role = Role::create([
      'name' => $request->name,
    ]);

    return response()->json([
      'status' => 201,
      'message' => 'تم إضافة الدور بنجاح',
      'data' => $role
    ], 201);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|string|max:255',
    ]);

    $role = Role::find($id);

    if ($role) {
      $role->update([
        'name' => $request->name,
      ]);

      return response()->json([
        'status' => 200,
        'message' => 'تم تحديث الدور بنجاح',
        'data' => $role
      ], 200);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'لم يتم العثور على الدور',
      ], 404);
    }
  }

  public function destroy($id)
  {
    $role = Role::find($id);

    if ($role) {
      $role->delete();

      return response()->json([
        'status' => 200,
        'message' => 'تم حذف الدور بنجاح',
      ], 200);
    } else {
      return response()->json([
        'status' => 404,
        'message' => 'لم يتم العثور على الدور',
      ], 404);
    }
  }
}
