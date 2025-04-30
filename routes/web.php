<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSetupController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\LandingController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

///TEMPORARY///
Route::middleware(['auth', 'applicant'])->group(function () {
    Route::get('/userprofile', fn () => view('profilebuilder/userprofile'));
    Route::post('/userprofile/store', [ProfileSetupController::class, 'storeUserProfile'])->name('userprofile.store');

    Route::get('/skills', fn () => view('profilebuilder/skills'));
    Route::post('/skills/store', [ProfileSetupController::class, 'storeSkills'])->name('skills.store');

    Route::get('/education', fn () => view('profilebuilder/education'));
    Route::post('/education/store', [ProfileSetupController::class, 'storeEducation'])->name('education.store');

    Route::get('/experience', fn () => view('profilebuilder/experience'));
    Route::post('/experience/store', [ProfileSetupController::class, 'storeExperience'])->name('experience.store');

    Route::get('/projects', fn () => view('profilebuilder/projects'));
    Route::post('/projects/store', [ProfileSetupController::class, 'storeProjects'])->name('projects.store');

    Route::get('/achievements', fn () => view('profilebuilder/achievement'));
    Route::post('/achievements/store', [ProfileSetupController::class, 'storeAchievements'])->name('achievements.store');

    Route::get('/summary', [ProfileSetupController::class, 'showSummary'])->name('summary');
});

// Recruiter-only access
Route::middleware(['auth', 'recruiter'])->group(function () {
    Route::get('/recruiter/profile', [RecruiterController::class, 'showProfileForm'])->name('recruiter.profile');
    Route::post('/recruiter/profile/store', [RecruiterController::class, 'storeProfile'])->name('recruiter.profile.store');
    Route::get('/dashboard', [RecruiterController::class, 'dashboard'])->name('recruiter.dashboard');
    Route::post('/recruiter/company/check', [RecruiterController::class, 'checkCompany'])->name('recruiter.company.check');
    Route::post('/recruiter/profile/store', [RecruiterController::class, 'storeProfile'])->name('recruiter.profile.store');

});


///TEMPORARY///
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';