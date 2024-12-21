<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		if (!Auth::attempt($request->only('email', 'password'))) {
			return response()->json(['message' => 'البيانات غير صحيحة'], 401);
		}

		/** @var User $user **/
		$user = Auth::user();
		$token = $user->createToken('token')->plainTextToken;

		return response()->json([
			'message' => 'تم تسجيل الدخول بنجاح',
			'data' => [
				'token' => $token,
				'user' => User::where('id', $user->getAuthIdentifier())->with('role')->first(),
			]
		]);
	}

	public function register(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
			'role_id' => 'required|integer|exists:roles,id',
		]);

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'role_id' => $request->role_id
		]);

		$token = $user->createToken('token')->plainTextToken;

		return response()->json([
			'message' => 'تم انشاء المستخدم بنجاح. تم ارسال رمز التحقق الى بريدك الالكتروني',
			'data' => [
				'user' => $user,
				'token' => $token,
			]
		], 201);
	}

	public function updateProfile(Request $request)
	{

		/** @var User $user **/
		$user = Auth::user();

		$request->validate([
			'name' => 'sometimes|string|max:255',
			'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
			'faculty_id' => 'sometimes|integer',
			'phone' => 'sometimes|string|max:20',
		]);

		$user->update($request->only('name', 'email', 'faculty_id', 'phone'));

		return response()->json([
			'message' => 'تم تحديث البيانات بنجاح',
			'user' => $user,
		]);
	}

	public function updatePassword(Request $request)
	{
		$request->validate([
			'current_password' => 'required',
			'new_password' => 'required|string|min:8|confirmed',
		]);

		/** @var User $user **/
		$user = Auth::user();

		if (!Hash::check($request->current_password, $user->password)) {
			return response()->json(['message' => 'Current password is incorrect'], 400);
		}

		$user->update([
			'password' => Hash::make($request->new_password),
		]);

		return response()->json(['message' => 'Password updated successfully']);
	}

	public function me(Request $request)
	{
		$user = User::where('id', $request->user()->id)->with('role')->first();
		return response()->json([
			'message' => 'Authorized',
			'data' => [
				'user' => $user,
			],
		]);
	}
}
