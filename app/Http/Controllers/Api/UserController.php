<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FranchiseRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

	public function roles(): JsonResponse
	{
		$roles = Role::all();
		return response()->json(["data" => $roles]);
	}

	public function getUserFranchiseRequests($id)
	{
		$franchiseRequests = FranchiseRequest::with([
			'franchise',
			'country',
			'type',
		])->where('user_id', $id)->get();
		return response()->json([
			'data' => $franchiseRequests,
			'status' => 200
		]);
	}

	public function index(): JsonResponse
	{
		$users = User::with('role')->orderBy('id', 'desc')->paginate();
		return response()->json(["data" => $users]);
	}


	public function store(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|unique:users,email',
			'password' => 'required|string',
			'role_id' => 'required|integer|exists:roles,id',
		]);

		$user = User::create([
			...$validated,
			'password' => Hash::make($validated['password']),
		]);

		return response()->json([
			"message" => "تم انشاء المستخدم بنجاح",
			"data" => $user,
			'status' => 201
		], 201);
	}

	public function show($user): JsonResponse
	{
		$data = User::find($user);
		if (!$data) {
			return response()->json(["message" => "User not found.", 'status' => 404], 404);
		}
		return response()->json(["data" => $data]);
	}

	public function update(Request $request, $user): JsonResponse
	{
		$data = User::find($user);
		if (!$data) {
			return response()->json(["message" => "User not found.", 'status' => 404], 404);
		}
		$validated = $request->validate([
			'name' => 'nullable|string|max:255',
			'email' => 'nullable|string',
			'role_id' => 'nullable|integer|exists:roles,id',
		]);
		User::where('id', $user)->update($request->all());
		return response()->json([
			"message" => "تم تحديث المستخدم بنجاح",
			"data" => $user,
			'status' => 200
		]);
	}

	public function destroy($user): JsonResponse
	{
		$data = User::find($user);
		if (!isset($data)) {
			return response()->json(["message" => "User not found.", 'status' => 404], 404);
		}
		$data->delete();
		return response()->json(["message" => "تم حذف المستخدم بنجاح"]);
	}
}
