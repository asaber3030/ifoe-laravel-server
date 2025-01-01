<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
	public function index()
	{
		$countries = Country::orderBy('id', 'desc')->all();

		return response()->json([
			'status' => 200,
			'data' => $countries
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
		]);

		$country = Country::create($request->all());

		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء البلد بنجاح.',
			'data' => $country
		], 201);
	}

	public function show($id)
	{
		$country = Country::find($id);

		if (!$country) {
			return response()->json([
				'status' => 404,
				'message' => 'لم يتم العثور على البلد.',
			], 404);
		}

		return response()->json([
			'status' => 200,
			'message' => 'تم جلب البلد بنجاح.',
			'data' => $country
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required|string|max:255',
		]);

		$country = Country::find($id);

		if (!$country) {
			return response()->json([
				'status' => 404,
				'message' => 'لم يتم العثور على البلد.',
			], 404);
		}

		$country->update($request->all());

		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث البلد بنجاح.',
			'data' => $country
		]);
	}

	public function destroy($id)
	{
		$country = Country::find($id);

		if (!$country) {
			return response()->json([
				'status' => 404,
				'message' => 'لم يتم العثور على البلد.',
			], 404);
		}

		$country->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف البلد بنجاح.',
		]);
	}
}
