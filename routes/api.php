<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ExperienceOptionController;
use App\Http\Controllers\Api\TechnologyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/skills/search', [SkillController::class, 'search']);

use App\Http\Controllers\Api\EducationMetaController;

Route::get('/educations/institutions/search', [EducationMetaController::class, 'searchInstitutions']);
Route::get('/educations/degrees/search', [EducationMetaController::class, 'searchDegrees']);
Route::get('/educations/fields/search', [EducationMetaController::class, 'searchFields']);


Route::get('/experiences/organizations/search', [ExperienceOptionController::class, 'searchOrganizations']);
Route::get('/experiences/titles/search', [ExperienceOptionController::class, 'searchTitles']);

Route::get('/projects/technologies/search', [TechnologyController::class, 'autocomplete']);

Route::get('/companies/search', function (Request $request) {
    $query = $request->q;

    $companies = \App\Models\Company::where('company_name', 'like', "%{$query}%")
        ->select('company_name')
        ->distinct()
        ->get();

    return response()->json($companies);
});