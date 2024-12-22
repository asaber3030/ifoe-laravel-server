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
			"data" => $blog,
			'status' => 201
		], 201);
	}

	public function show($blog): JsonResponse
	{
		$data = Blog::find($blog);
		if (!$data) {
			return response()->json(["message" => "Blog not found.", 'status' => 404], 404);
		}
		return response()->json(["data" => $data]);
	}

	public function update(Request $request, $blog): JsonResponse
	{
		$data = Blog::find($blog);
		if (!$data) {
			return response()->json(["message" => "Blog not found.", 'status' => 404], 404);
		}
		$validated = $request->validate([
			'title' => 'sometimes|string|max:255',
			'short_text' => 'sometimes|string',
			'blog_content' => 'sometimes|string',
			'image_url' => 'sometimes|url',
		]);
		Blog::where('id', $blog)->update($request->all());
		return response()->json([
			"message" => "تم تحديث المدونة بنجاح",
			"data" => $blog,
			'status' => 200
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
