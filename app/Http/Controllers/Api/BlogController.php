<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{

	public function index(): JsonResponse
	{
		$blogs = Blog::paginate();
		return response()->json(["data" => $blogs]);
	}

	public function store(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'title' => 'required|string|max:255',
			'short_text' => 'required|string',
			'blog_content' => 'required|string',
			'image_url' => 'nullable|url',
		]);

		$blog = Blog::create($validated);

		return response()->json([
			"message" => "تم انشاء المدونة بنجاح",
			"data" => $blog
		], 201);
	}

	public function show($blog): JsonResponse
	{
		$data = Blog::find($blog);
		if (!isset($data)) {
			return response()->json(["message" => "Blog not found.", 'status' => 404], 404);
		}
		return response()->json(["data" => $blog]);
	}

	public function update(Request $request, $blog): JsonResponse
	{
		$data = Blog::find($blog);
		if (!isset($data)) {
			return response()->json(["message" => "Blog not found.", 'status' => 404], 404);
		}
		$validated = $request->validate([
			'title' => 'nullable|string|max:255',
			'short_text' => 'nullable|string',
			'blog_content' => 'nullable|string',
			'image_url' => 'nullable|url',
		]);
		$blog->update($validated);
		return response()->json([
			"message" => "تم تحديث المدونة بنجاح",
			"data" => $blog
		]);
	}

	public function destroy($blog): JsonResponse
	{
		$data = Blog::find($blog);
		if (!isset($data)) {
			return response()->json(["message" => "Blog not found.", 'status' => 404], 404);
		}
		$blog->delete();
		return response()->json(["message" => "تم حذف المدونة بنجاح"]);
	}
}
