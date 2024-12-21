<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FranchiseImage;

class FranchiseImageController extends Controller
{
	public function index()
	{
		$franchiseImages = FranchiseImage::all();
		$response = [
			'status' => 200,
			'message' => 'تم جلب الصور بنجاح',
			'data' => $franchiseImages
		];
		return response()->json($response, 200);
	}

	public function show($id)
	{
		$franchiseImage = FranchiseImage::find($id);

		if (!$franchiseImage) {
			return response()->json([
				'status' => 404,
				'message' => 'الصورة غير موجودة'
			], 404);
		}

		return response()->json([
			'status' => 200,
			'message' => 'تم جلب الصورة بنجاح',
			'data' => $franchiseImage
		], 200);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'franchise_id' => 'required|exists:franchises,id',
			'image_url' => 'required|url'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'البيانات المدخلة غير صحيحة',
				'errors' => $validator->errors()
			], 422);
		}

		$franchiseImage = FranchiseImage::create([
			'franchise_id' => $request->franchise_id,
			'image_url' => $request->image_url
		]);

		return response()->json([
			'status' => 201,
			'message' => 'تم إضافة الصورة بنجاح',
			'data' => $franchiseImage
		], 201);
	}

	public function update(Request $request, $id)
	{
		$franchiseImage = FranchiseImage::find($id);

		if (!$franchiseImage) {
			return response()->json([
				'status' => 404,
				'message' => 'الصورة غير موجودة'
			], 404);
		}

		$validator = Validator::make($request->all(), [
			'franchise_id' => 'required|exists:franchises,id',
			'image_url' => 'required|url'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'البيانات المدخلة غير صحيحة',
				'errors' => $validator->errors()
			], 422);
		}

		$franchiseImage->update([
			'franchise_id' => $request->franchise_id,
			'image_url' => $request->image_url
		]);

		return response()->json([
			'status' => 200,
			'message' => 'تم تعديل الصورة بنجاح',
			'data' => $franchiseImage
		], 200);
	}

	public function destroy($id)
	{
		$franchiseImage = FranchiseImage::find($id);

		if (!$franchiseImage) {
			return response()->json([
				'status' => 404,
				'message' => 'الصورة غير موجودة'
			], 404);
		}

		$franchiseImage->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف الصورة بنجاح'
		], 200);
	}
}
