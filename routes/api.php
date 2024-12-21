<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContractPeriodController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\TrainingPeriodController;
use App\Http\Controllers\Api\SpaceRequiredController;
use App\Http\Controllers\Api\EquipmentCostController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UnitController;

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

	Route::get('/categories', [CategoryController::class, 'index']);
	Route::get('/categories/{category}', [CategoryController::class, 'show']);

	Route::get('contract-periods', [ContractPeriodController::class, 'index']);
	Route::get('contract-periods/{id}', [ContractPeriodController::class, 'show']);

	Route::get('countries', [CountryController::class, 'index']);
	Route::get('countries/{id}', [CountryController::class, 'show']);

	Route::get('training-periods', [TrainingPeriodController::class, 'index']);
	Route::get('training-periods/{id}', [TrainingPeriodController::class, 'show']);

	Route::get('equipments-cost', [EquipmentCostController::class, 'index']);
	Route::get('equipments-cost/{id}', [EquipmentCostController::class, 'show']);

	Route::get('spaces-required', [SpaceRequiredController::class, 'index']);
	Route::get('spaces-required/{id}', [SpaceRequiredController::class, 'show']);

	Route::get('units', [UnitController::class, 'index']);
	Route::get('units/{id}', [UnitController::class, 'show']);

	Route::get('roles', [RoleController::class, 'index']);
	Route::get('roles/{id}', [RoleController::class, 'show']);

	Route::middleware('auth:sanctum')->group(function () {
		Route::middleware('is_admin')->group(function () {
			// Blogs
			Route::post('/blogs', [BlogController::class, 'store']);
			Route::patch('/blogs/{blog}', [BlogController::class, 'update']);
			Route::delete('/blogs/{blog}', [BlogController::class, 'destroy']);

			// Categories
			Route::post('/categories', [CategoryController::class, 'store']);
			Route::patch('/categories/{category}', [CategoryController::class, 'update']);
			Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

			// Contract Periods
			Route::post('contract-periods', [ContractPeriodController::class, 'store']);
			Route::patch('contract-periods/{id}', [ContractPeriodController::class, 'update']);
			Route::delete('contract-periods/{id}', [ContractPeriodController::class, 'destroy']);

			// Countries
			Route::post('countries', [CountryController::class, 'store']);
			Route::patch('countries/{id}', [CountryController::class, 'update']);
			Route::delete('countries/{id}', [CountryController::class, 'destroy']);

			// Training Periods
			Route::post('training-periods', [TrainingPeriodController::class, 'store']);
			Route::patch('training-periods/{id}', [TrainingPeriodController::class, 'update']);
			Route::delete('training-periods/{id}', [TrainingPeriodController::class, 'destroy']);

			// Equipment Cost
			Route::post('equipments-cost', [EquipmentCostController::class, 'store']);
			Route::patch('equipments-cost/{id}', [EquipmentCostController::class, 'update']);
			Route::delete('equipments-cost/{id}', [EquipmentCostController::class, 'destroy']);

			// Spaces Required
			Route::post('spaces-required', [SpaceRequiredController::class, 'store']);
			Route::patch('spaces-required/{id}', [SpaceRequiredController::class, 'update']);
			Route::delete('spaces-required/{id}', [SpaceRequiredController::class, 'destroy']);

			// Units
			Route::post('units', [UnitController::class, 'store']);
			Route::patch('units/{id}', [UnitController::class, 'update']);
			Route::delete('units/{id}', [UnitController::class, 'destroy']);

			// Roles
			Route::post('roles', [RoleController::class, 'store']);
			Route::patch('roles/{id}', [RoleController::class, 'update']);
			Route::delete('roles/{id}', [RoleController::class, 'destroy']);
		});
	});
});
