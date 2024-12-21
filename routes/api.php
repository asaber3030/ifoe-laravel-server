<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;

Route::as('api.')->prefix('v1/')->group(function () {

	Route::controller(AuthController::class)->group(function () {
		Route::post('login', 'login')->name('login');
		Route::post('register', 'register')->name('register');

		Route::middleware('auth:sanctum')->group(function () {
			Route::get('me', 'me');
			Route::patch('update/profile', 'updateProfile');
			Route::patch('update/password', 'updatePassword');
		});
	});

	Route::get('/blogs', [BlogController::class, 'index']);
	Route::get('/blogs/{blog}', [BlogController::class, 'show']);

	Route::middleware('auth:sanctum')->group(function () {
		Route::middleware('is_admin')->group(function () {
			Route::post('/blogs', [BlogController::class, 'store']);
			Route::patch('/blogs/{blog}', [BlogController::class, 'update']); // Partially update a specific blog
			Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']); // Delete a specific blog
		});
	});
});
