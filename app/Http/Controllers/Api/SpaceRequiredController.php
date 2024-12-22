<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpaceRequired;

class SpaceRequiredController extends Controller
{
	public function index()
	{
		$spacesRequired = SpaceRequired::with('unit')->get();
		return response()->json([
			'status' => 200,
			'data' => $spacesRequired
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$spaceRequired = SpaceRequired::create($request->all());
		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء المساحة بنجاح.',
			'data' => $spaceRequired
		], 201);
	}

	public function show($id)
	{
		$spaceRequired = SpaceRequired::with('unit')->find($id);

		if (!$spaceRequired) {
			return response()->json([
				'status' => 404,
				'message' => 'المساحة غير موجودة.',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'data' => $spaceRequired
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$spaceRequired = SpaceRequired::find($id);

		if (!$spaceRequired) {
			return response()->json([
				'status' => 404,
				'message' => 'المساحة غير موجودة.',
			], 404);
		}

		$spaceRequired->update($request->all());
		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث المساحة بنجاح.',
			'data' => $spaceRequired
		]);
	}

	public function destroy($id)
	{
		$spaceRequired = SpaceRequired::find($id);

		if (!$spaceRequired) {
			return response()->json([
				'status' => 404,
				'message' => 'المساحة غير موجودة.',
			], 404);
		}

		$spaceRequired->delete();
		return response()->json([
			'status' => 200,
			'message' => 'تم حذف المساحة بنجاح.',
		]);
	}
}
