<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

	public function index(): JsonResponse
	{
		$categories = Category::orderBy('id', 'desc')->get();
		return response()->json([
			'status' => 200,
			'message' => 'Categories retrieved successfully.',
			'data' => $categories,
		]);
	}

	public function store(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
		]);

		$category = Category::create($validated);

		return response()->json([
			'status' => 201,
			'message' => 'تم إنشاء القسم بنجاح.',
			'data' => $category,
		], 201);
	}


	public function show(Category $category): JsonResponse
	{
		return response()->json([
			'status' => 200,
			'data' => $category,
		]);
	}

	public function update(Request $request, Category $category): JsonResponse
	{
		$validated = $request->validate([
			'name' => 'sometimes|required|string|max:255',
		]);

		$category->update($validated);

		return response()->json([
			'status' => 200,
			'message' => 'تم تحديث القسم بنجاح.',
			'data' => $category,
		]);
	}

	public function destroy(Category $category): JsonResponse
	{
		$category->delete();

		return response()->json([
			'status' => 200,
			'message' => 'تم حذف القسم بنجاح.',
		]);
	}
}
