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
use App\Http\Controllers\Api\FranchiseTypeController;
use App\Http\Controllers\Api\FranchiseController;
use App\Http\Controllers\Api\FranchiseCharacteristicController;
use App\Http\Controllers\Api\FranchiseImageController;
use App\Http\Controllers\Api\FranchiseRequestController;
use App\Http\Controllers\Api\FranchiseRequestHistoryController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\UserController;

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

	Route::get('/users', [UserController::class, 'index']);
	Route::get('/users/{user}/requests', [UserController::class, 'getUserFranchiseRequests']);

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

	Route::get('franchises', [FranchiseController::class, 'index']);
	Route::get('franchises-filter', [FranchiseController::class, 'filter']);
	Route::get('franchises/{id}', [FranchiseController::class, 'show']);
	Route::get('franchises/{id}/requests', [FranchiseController::class, 'showRequests']);
	Route::get('franchises/{id}/requests/{history}', [FranchiseController::class, 'showRequestHistory']);
	Route::get('franchises/{id}/images', [FranchiseController::class, 'showImages']);

	Route::get('franchise-types', [FranchiseTypeController::class, 'index']);
	Route::get('franchise-types/{id}', [FranchiseTypeController::class, 'show']);

	Route::get('franchise-characteristics', [FranchiseCharacteristicController::class, 'index']);
	Route::get('franchise-characteristics/{id}', [FranchiseCharacteristicController::class, 'show']);

	Route::get('franchise-images', [FranchiseImageController::class, 'index']);
	Route::get('franchise-images/{id}', [FranchiseImageController::class, 'show']);

	Route::get('franchise-requests', [FranchiseRequestController::class, 'index']);
	Route::get('franchise-requests/{id}', [FranchiseRequestController::class, 'show']);
	Route::get('franchise-requests/{id}/history', [FranchiseRequestController::class, 'showHistory']);

	Route::get('franchise-requests-history', [FranchiseRequestHistoryController::class, 'index']);
	Route::get('franchise-requests-history/{id}', [FranchiseRequestHistoryController::class, 'show']);

	Route::get('partners/', [PartnerController::class, 'index']);
	Route::get('partners/{id}', [PartnerController::class, 'show']);

	Route::middleware('auth:sanctum')->group(function () {
		Route::middleware('is_admin')->group(function () {

			// Partners
			Route::post('partners/', [PartnerController::class, 'store']);
			Route::patch('partners/{id}', [PartnerController::class, 'update']);
			Route::delete('partners/{id}', [PartnerController::class, 'destroy']);

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

			// Franchises
			Route::post('franchises', [FranchiseController::class, 'store']);
			Route::patch('franchises/{id}', [FranchiseController::class, 'update']);
			Route::delete('franchises/{id}', [FranchiseController::class, 'destroy']);

			// Franchise Types
			Route::post('franchise-types', [FranchiseTypeController::class, 'store']);
			Route::patch('franchise-types/{id}', [FranchiseTypeController::class, 'update']);
			Route::delete('franchise-types/{id}', [FranchiseTypeController::class, 'destroy']);

			// Franchise characteristics
			Route::post('franchise-characteristics', [FranchiseCharacteristicController::class, 'store']);
			Route::patch('franchise-characteristics/{id}', [FranchiseCharacteristicController::class, 'update']);
			Route::delete('franchise-characteristics/{id}', [FranchiseCharacteristicController::class, 'destroy']);

			// Franchise Images
			Route::post('franchise-images', [FranchiseImageController::class, 'store']);
			Route::patch('franchise-images/{id}', [FranchiseImageController::class, 'update']);
			Route::delete('franchise-images/{id}', [FranchiseImageController::class, 'destroy']);

			// Franchise Requests
			Route::post('franchise-requests', [FranchiseRequestController::class, 'store']);
			Route::patch('franchise-requests/{id}', [FranchiseRequestController::class, 'update']);
			Route::delete('franchise-requests/{id}', [FranchiseRequestController::class, 'destroy']);

			// Franchise Requests History
			Route::post('franchise-requests-history', [FranchiseRequestHistoryController::class, 'store']);
			Route::patch('franchise-requests-history/{id}', [FranchiseRequestHistoryController::class, 'update']);
			Route::delete('franchise-requests-history/{id}', [FranchiseRequestHistoryController::class, 'destroy']);
		});
	});
});
