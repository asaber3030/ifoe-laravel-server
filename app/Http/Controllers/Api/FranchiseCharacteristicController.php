<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseCharacteristic;
use Illuminate\Support\Facades\Validator;

class FranchiseCharacteristicController extends Controller
{

	public function index()
	{
		$franchiseCharacteristics = FranchiseCharacteristic::all();

		return response()->json([
			'status' => 200,
			'message' => 'تم العثور على خصائص الفرنشايز بنجاح',
			'data' => $franchiseCharacteristics,
		], 200);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'franchise_fees' => 'required|numeric',
			'royalty_fees' => 'required|numeric',
			'marketing_fees' => 'required|numeric',
			'investments_cost' => 'required|numeric',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'التحقق من البيانات فشل.',
				'errors' => $validator->errors(),
			], 422);
		}

		$franchiseCharacteristic = FranchiseCharacteristic::create($request->all());

		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء خصائص الفرنشايز بنجاح',
			'data' => $franchiseCharacteristic,
		], 201);
	}

	public function show($id)
	{
		$franchiseCharacteristic = FranchiseCharacteristic::find($id);

		if (!$franchiseCharacteristic) {
			return response()->json([
				'status' => 404,
				'message' => 'خصائص الفرنشايز غير موجودة',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'message' => 'تم العثور على خصائص الفرنشايز بنجاح',
			'data' => $franchiseCharacteristic,
		], 200);
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'franchise_fees' => 'nullable|numeric',
			'royalty_fees' => 'nullable|numeric',
			'marketing_fees' => 'nullable|numeric',
			'investments_cost' => 'nullable|numeric',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'التحقق من البيانات فشل.',
				'errors' => $validator->errors(),
			], 422);
		}

		$franchiseCharacteristic = FranchiseCharacteristic::find($id);

		if (!$franchiseCharacteristic) {
			return response()->json([
				'status' => 404,
				'message' => 'خصائص الفرنشايز غير موجودة',
			], 404);
		}

		$franchiseCharacteristic->update($request->all());

		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث خصائص الفرنشايز بنجاح',
			'data' => $franchiseCharacteristic,
		], 200);
	}

	public function destroy($id)
	{
		$franchiseCharacteristic = FranchiseCharacteristic::find($id);

		if (!$franchiseCharacteristic) {
			return response()->json([
				'status' => 404,
				'message' => 'خصائص الفرنشايز غير موجودة',
			], 404);
		}

		$franchiseCharacteristic->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف خصائص الفرنشايز بنجاح',
		], 200);
	}
}
