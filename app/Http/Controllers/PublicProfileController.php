<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
   public function show($id)
{
    $user = User::with([
        'profile',
        'experiences',
        'skills',
        'projects',
        'educations',
        'achievements' => fn($q) => $q->latest()
    ])->findOrFail($id);

    // Destructure for clarity (optional)
    $profile = $user->profile;
    $skills = $user->skills;
    $experiences = $user->experiences;
    $projects = $user->projects;
    $educations = $user->educations;
    $achievements = $user->achievements;

    return view('public-profile.show', compact(
        'user',
        'profile',
        'skills',
        'experiences',
        'projects',
        'educations',
        'achievements'
    ));
}
}