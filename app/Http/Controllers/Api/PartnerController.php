<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
	public function index()
	{
		$partners = Partner::orderBy('id', 'desc')->get();

		return response()->json([
			'status' => 200,
			'message' => 'تم استرجاع البيانات بنجاح',
			'data' => $partners,
		]);
	}

	public function show($id)
	{
		$partner = Partner::find($id);

		if (!$partner) {
			return response()->json([
				'status' => 404,
				'message' => 'العنصر غير موجود',
			]);
		}

		return response()->json([
			'status' => 200,
			'message' => 'تم استرجاع العنصر بنجاح',
			'data' => $partner,
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'image_url' => 'required|url',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'بيانات الإدخال غير صحيحة',
				'errors' => $validator->errors(),
			]);
		}

		$partner = Partner::create($request->all());

		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء الشريك بنجاح',
			'data' => $partner,
		]);
	}

	public function update(Request $request, $id)
	{
		$partner = Partner::find($id);

		if (!$partner) {
			return response()->json([
				'status' => 404,
				'message' => 'العنصر غير موجود',
			]);
		}

		$validator = Validator::make($request->all(), [
			'image_url' => 'sometimes|url',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'بيانات الإدخال غير صحيحة',
				'errors' => $validator->errors(),
			]);
		}

		$partner->update($request->all());

		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث الشريك بنجاح',
			'data' => $partner,
		]);
	}

	public function destroy($id)
	{
		$partner = Partner::find($id);

		if (!$partner) {
			return response()->json([
				'status' => 404,
				'message' => 'العنصر غير موجود',
			]);
		}

		$partner->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف الشريك بنجاح',
		]);
	}
}
