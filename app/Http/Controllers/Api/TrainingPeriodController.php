<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TrainingPeriod;

class TrainingPeriodController extends Controller
{
	public function index()
	{
		$trainingPeriods = TrainingPeriod::with('unit')->get(); // Includes the related Unit data
		return response()->json([
			'status' => 200,
			'data' => $trainingPeriods
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$trainingPeriod = TrainingPeriod::create($request->all());
		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء فترة التدريب بنجاح.',
			'data' => $trainingPeriod
		], 201);
	}

	public function show($id)
	{
		$trainingPeriod = TrainingPeriod::with('unit')->find($id);

		if (!$trainingPeriod) {
			return response()->json([
				'status' => 404,
				'message' => 'فترة التدريب غير موجودة.',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'data' => $trainingPeriod
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'value' => 'required|integer',
			'unit_id' => 'required|exists:units,id',
		]);

		$trainingPeriod = TrainingPeriod::find($id);

		if (!$trainingPeriod) {
			return response()->json([
				'status' => 404,
				'message' => 'فترة التدريب غير موجودة.',
			], 404);
		}

		$trainingPeriod->update($request->all());
		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث فترة التدريب بنجاح.',
			'data' => $trainingPeriod
		]);
	}

	public function destroy($id)
	{
		$trainingPeriod = TrainingPeriod::find($id);

		if (!$trainingPeriod) {
			return response()->json([
				'status' => 404,
				'message' => 'فترة التدريب غير موجودة.',
			], 404);
		}

		$trainingPeriod->delete();
		return response()->json([
			'status' => 200,
			'message' => 'تم حذف فترة التدريب بنجاح.',
		]);
	}
}
