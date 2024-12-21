<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EquipmentCost;

class EquipmentCostController extends Controller
{
	public function index()
	{
		$equpimentCosts = EquipmentCost::with('unit')->get(); // Includes the related Unit data
		return response()->json([
			'status' => 200,
			'data' => $equpimentCosts
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$equipmentCost = EquipmentCost::create($request->all());
		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء تكلفة الاداءه بنجاح.',
			'data' => $equipmentCost
		], 201);
	}

	public function show($id)
	{
		$equipmentCost = EquipmentCost::with('unit')->find($id);

		if (!$equipmentCost) {
			return response()->json([
				'status' => 404,
				'message' => 'تكلفة الاداءه غير موجودة.',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'data' => $equipmentCost
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$equipmentCost = EquipmentCost::find($id);

		if (!$equipmentCost) {
			return response()->json([
				'status' => 404,
				'message' => 'تكلفة الاداءه غير موجودة.',
			], 404);
		}

		$equipmentCost->update($request->all());
		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث تكلفة الاداءه بنجاح.',
			'data' => $equipmentCost
		]);
	}

	public function destroy($id)
	{
		$equipmentCost = EquipmentCost::find($id);

		if (!$equipmentCost) {
			return response()->json([
				'status' => 404,
				'message' => 'تكلفة الاداءه غير موجودة.',
			], 404);
		}

		$equipmentCost->delete();
		return response()->json([
			'status' => 200,
			'message' => 'تم حذف تكلفة الاداءه بنجاح.',
		]);
	}
}
