<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FranchiseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
}
