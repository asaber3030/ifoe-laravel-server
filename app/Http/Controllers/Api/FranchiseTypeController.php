<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseType;

class FranchiseTypeController extends Controller
{
	public function index()
	{
		$franchiseTypes = FranchiseType::orderBy('id', 'desc')->all();

		return response()->json([
			'status' => 200,
			'message' => 'تم جلب جميع أنواع الامتيازات',
			'data' => $franchiseTypes ?: null,
		], 200);
	}

	public function show($id)
	{
		$franchiseType = FranchiseType::find($id);

		if ($franchiseType) {
			return response()->json([
				'status' => 200,
				'message' => 'تم جلب تفاصيل نوع الامتياز',
				'data' => $franchiseType,
			], 200);
		} else {
			return response()->json([
				'status' => 404,
				'message' => 'لم يتم العثور على نوع الامتياز',
			], 404);
		}
	}

	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'franchise_type' => 'required|string|max:255',
			'city_of_opening' => 'required|string|max:255',
			'confirmation' => 'required|boolean',
		]);

		$franchiseType = FranchiseType::create($validatedData);

		return response()->json([
			'status' => 201,
			'message' => 'تم إضافة نوع الامتياز بنجاح',
			'data' => $franchiseType,
		], 201);
	}

	public function update(Request $request, $id)
	{
		$franchiseType = FranchiseType::find($id);

		if ($franchiseType) {
			$validatedData = $request->validate([
				'franchise_type' => 'required|string|max:255',
				'city_of_opening' => 'required|string|max:255',
				'confirmation' => 'required|boolean',
			]);

			$franchiseType->update($validatedData);

			return response()->json([
				'status' => 200,
				'message' => 'تم تحديث نوع الامتياز بنجاح',
				'data' => $franchiseType,
			], 200);
		} else {
			return response()->json([
				'status' => 404,
				'message' => 'لم يتم العثور على نوع الامتياز',
			], 404);
		}
	}

	public function destroy($id)
	{
		$franchiseType = FranchiseType::find($id);

		if ($franchiseType) {
			$franchiseType->delete();

			return response()->json([
				'status' => 200,
				'message' => 'تم حذف نوع الامتياز بنجاح',
			], 200);
		} else {
			return response()->json([
				'status' => 404,
				'message' => 'لم يتم العثور على نوع الامتياز',
			], 404);
		}
	}
}
