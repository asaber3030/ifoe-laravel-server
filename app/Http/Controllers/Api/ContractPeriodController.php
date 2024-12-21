<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContractPeriod;

class ContractPeriodController extends Controller
{
	public function index()
	{
		$contractPeriods = ContractPeriod::with('unit')->get(); // Includes the related Unit data
		return response()->json([
			'status' => 200,
			'data' => $contractPeriods
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$contractPeriod = ContractPeriod::create($request->all());
		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء فترة العقد بنجاح.',
			'data' => $contractPeriod
		], 201);
	}

	public function show($id)
	{
		$contractPeriod = ContractPeriod::with('unit')->find($id);

		if (!$contractPeriod) {
			return response()->json([
				'status' => 404,
				'message' => 'فترة العقد غير موجودة.',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'data' => $contractPeriod
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$contractPeriod = ContractPeriod::find($id);

		if (!$contractPeriod) {
			return response()->json([
				'status' => 404,
				'message' => 'فترة العقد غير موجودة.',
			], 404);
		}

		$contractPeriod->update($request->all());
		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث فترة العقد بنجاح.',
			'data' => $contractPeriod
		]);
	}

	public function destroy($id)
	{
		$contractPeriod = ContractPeriod::find($id);

		if (!$contractPeriod) {
			return response()->json([
				'status' => 404,
				'message' => 'فترة العقد غير موجودة.',
			], 404);
		}

		$contractPeriod->delete();
		return response()->json([
			'status' => 200,
			'message' => 'تم حذف فترة العقد بنجاح.',
		]);
	}
}
