<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FranchiseRequestHistory;

class FranchiseRequestHistoryController extends Controller
{
	public function index()
	{
		$history = FranchiseRequestHistory::orderBy('id', 'desc')->get();
		return response()->json([
			'status' => 200,
			'message' => 'تم استرجاع سجل الطلبات بنجاح',
			'data' => $history
		]);
	}

	public function show($id)
	{
		$history = FranchiseRequestHistory::find($id);

		if ($history) {
			return response()->json([
				'status' => 200,
				'message' => 'تم استرجاع السجل بنجاح',
				'data' => $history
			]);
		}

		return response()->json([
			'status' => 404,
			'message' => 'السجل غير موجود'
		], 404);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'franchise_request_id' => 'required|exists:franchise_requests,id',
			'status' => 'required|string',
			'changed_at' => 'required|date',
			'changed_by' => 'required|exists:users,id',
			'remarks' => 'nullable|string'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'هناك خطأ في المدخلات',
				'errors' => $validator->errors()
			], 422);
		}

		$history = FranchiseRequestHistory::create($request->all());

		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء السجل بنجاح',
			'data' => $history
		]);
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'status' => 'required|string',
			'changed_at' => 'required|date',
			'changed_by' => 'required|exists:users,id',
			'remarks' => 'nullable|string'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 422,
				'message' => 'هناك خطأ في المدخلات',
				'errors' => $validator->errors()
			], 422);
		}

		$history = FranchiseRequestHistory::find($id);

		if (!$history) {
			return response()->json([
				'status' => 404,
				'message' => 'السجل غير موجود'
			], 404);
		}

		$history->update($request->all());

		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث السجل بنجاح',
			'data' => $history
		]);
	}

	public function destroy($id)
	{
		$history = FranchiseRequestHistory::find($id);

		if (!$history) {
			return response()->json([
				'status' => 404,
				'message' => 'السجل غير موجود'
			], 404);
		}

		$history->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف السجل بنجاح'
		]);
	}
}
