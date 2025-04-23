<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;

class RecruiterController extends Controller
{
    public function showProfileForm()
    {
        return view('recruiterbuilder.profile');
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'company_description' => 'nullable|string',
            
        ]);
        

        // Check if company already exists
        $company = Company::firstOrCreate(
            ['company_name' => $request->company_name],
            [
                'user_id' => Auth::id(),
                'industry' => $request->industry,
                'website' => $request->website,
                'company_description' => $request->company_description,
            ]
            
        );
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company_logos', 'public');
            $company->logo_url = $logoPath;
            $company->save();
        }
        
        /** @var \App\Models\User $user */
        // Associate recruiter with the company
        $user = Auth::user();
        $user->company_id = $company->id;
        $user->save();

        return redirect('/dashboard')->with('success', 'Company profile saved!');
    }

    public function dashboard()
    {
        return view('recruiterbuilder.dashboard');
    }
    public function checkCompany(Request $request)
{
    $request->validate(['company_name' => 'required|string']);

    $company = Company::where('company_name', $request->company_name)->first();

    if ($company) {
        // Link to existing company
        $user = Auth::user();
        $user->company_id = $company->id;
        /** @var \App\Models\User $user */
        $user->save();

        return redirect('/dashboard')->with('success', 'Company found and linked.');
    }

    // If not found, show form to fill rest of company details
    return view('recruiterbuilder.company-details', [
        'company_name' => $request->company_name,
    ]);
}


}