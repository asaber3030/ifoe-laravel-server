<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$requestUser = $request->user();
		$user = User::where('id', $requestUser->getAuthIdentifier())->with('role')->first();
		if ($user->role->name !== 'Admin') {
			return response()->json(['message' => 'ليس لديك صلاحية الوصول الى هذه الصفحة'], 403);
		}
		return $next($request);
	}
}
