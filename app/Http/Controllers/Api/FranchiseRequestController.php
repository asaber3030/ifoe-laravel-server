<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FranchiseRequest;
use App\Models\FranchiseRequestHistory;

class FranchiseRequestController extends Controller
{
	public function index()
	{
		$franchiseRequests = FranchiseRequest::with('user')->get();
		return response()->json([
			'status' => 200,
			'message' => 'تم جلب طلبات الامتياز بنجاح',
			'data' => $franchiseRequests ?: null
		]);
	}

	public function show($id)
	{
		$franchiseRequest = FranchiseRequest::with(['user',  'type', 'franchise'])->find($id);

		if (!$franchiseRequest) {
			return response()->json([
				'status' => 404,
				'message' => 'طلب الامتياز غير موجود',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'message' => 'تم جلب طلب الامتياز بنجاح',
			'data' => $franchiseRequest
		]);
	}

	public function showHistory($id)
	{
		$history = FranchiseRequestHistory::with('changedBy')->where('franchise_request_id', $id)->get();

		if (!$history) {
			return response()->json([
				'status' => 404,
				'message' => 'طلب الامتياز غير موجود',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'data' => $history
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'user_id' => 'required|exists:users,id',
			'franchise_id' => 'required|exists:franchises,id',
			'full_name' => 'required|string',
			'phone' => 'required|string',
			'country_id' => 'required|exists:countries,id',
			'city' => 'required|string',
			'company_name' => 'required|string',
			'business_type' => 'required|string',
			'have_experience' => 'required|boolean',
			'franchise_type_id' => 'required|exists:franchise_types,id',
			'status' => 'required|in:Pending,Approved,Rejected',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'يوجد خطأ في البيانات المدخلة',
				'data' => $validator->errors()
			], 400);
		}

		$franchiseRequest = FranchiseRequest::create($request->all());

		return response()->json([
			'status' => 201,
			'message' => 'تم إضافة طلب الامتياز بنجاح',
			'data' => $franchiseRequest
		]);
	}

	public function update(Request $request, $id)
	{
		$franchiseRequest = FranchiseRequest::find($id);

		$validator = Validator::make($request->all(), [
			'user_id' => 'sometimes|exists:users,id',
			'franchise_id' => 'sometimes|exists:franchises,id',
			'full_name' => 'sometimes|string',
			'phone' => 'sometimes|string',
			'country_id' => 'sometimes|exists:countries,id',
			'city' => 'sometimes|string',
			'company_name' => 'sometimes|string',
			'business_type' => 'sometimes|string',
			'have_experience' => 'sometimes|boolean',
			'franchise_type_id' => 'sometimes|exists:franchise_types,id',
			'status' => 'sometimes|in:Pending,Approved,Rejected',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 400,
				'message' => 'يوجد خطأ في البيانات المدخلة',
				'data' => $validator->errors()
			], 400);
		}

		if (!$franchiseRequest) {
			return response()->json([
				'status' => 404,
				'message' => 'طلب الامتياز غير موجود'
			], 404);
		}

		$franchiseRequest->update($request->all());

		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث طلب الامتياز بنجاح',
			'data' => $franchiseRequest
		]);
	}

	public function destroy($id)
	{
		$franchiseRequest = FranchiseRequest::find($id);

		if (!$franchiseRequest) {
			return response()->json([
				'status' => 404,
				'message' => 'طلب الامتياز غير موجود'
			], 404);
		}

		$franchiseRequest->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف طلب الامتياز بنجاح'
		]);
	}
}
