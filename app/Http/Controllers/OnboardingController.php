<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OnboardingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user has completed onboarding
        if ($user->hasCompletedOnboarding()) {
            return redirect()->route('dashboard');
        }

        // Get current step from session or default to 1
        $currentStep = Session::get('onboarding_step', 1);

        \Log::info('Onboarding index', ['user_id' => $user->id, 'current_step' => $currentStep]);

        return $this->showStep($currentStep);
    }

    public function showStep($step)
    {
        $user = Auth::user();

        // Validate step
        if ($step < 1 || $step > 5) {
            return redirect()->route('onboarding.index');
        }

        // Check if user can access this step
        if (!$this->canAccessStep($user, $step)) {
            return redirect()->route('onboarding.index');
        }

        $steps = [
            1 => 'welcome',
            2 => 'role-selection',
            3 => 'profile-setup',
            4 => 'kyc-verification',
            5 => 'completion'
        ];

        $viewName = $steps[$step] ?? 'welcome';

        \Log::info('Showing onboarding step', ['step' => $step, 'user_id' => $user->id]);

        return view('onboarding.' . $viewName, compact('step', 'user'));
    }

    public function processStep(Request $request)
    {
        $user = Auth::user();
        $currentStep = Session::get('onboarding_step', 1);

        \Log::info('Processing onboarding step', ['step' => $currentStep, 'user_id' => $user->id]);

        switch ($currentStep) {
            case 1:
                return $this->processWelcome($request);
            case 2:
                return $this->processRoleSelection($request);
            case 3:
                return $this->processProfileSetup($request);
            case 4:
                return $this->processKycVerification($request);
            case 5:
                return $this->processCompletion($request);
            default:
                return redirect()->route('onboarding.index');
        }
    }

    private function processWelcome(Request $request)
    {
        Session::put('onboarding_step', 2);
        return redirect()->route('onboarding.step', 2);
    }

    private function processRoleSelection(Request $request)
    {
        $request->validate([
            'role' => 'required|in:client,freelancer,vendor',
        ]);

        $user = Auth::user();
        $selectedRole = $request->role;

        // Assign the selected role
        $user->assignRole($selectedRole);
        $user->update(['current_role' => $selectedRole]);

        // Create profile if it doesn't exist
        if (!$user->profile) {
            $user->profile()->create([
                'bio' => '',
                'skills' => [],
                'is_verified' => false,
            ]);
        }

        Session::put('onboarding_step', 3);
        return redirect()->route('onboarding.step', 3);
    }

    private function processProfileSetup(Request $request)
    {
        \Log::info('Processing profile setup', ['user_id' => Auth::id(), 'request_data' => $request->all()]);

        $request->validate([
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|string', // Accept JSON string
            'location' => 'nullable|string|max:255',
            'portfolio_url' => 'nullable|url',
        ]);

        $user = Auth::user();

        // Handle skills from the hidden input
        $skills = [];
        if ($request->has('skills') && is_string($request->skills)) {
            $decodedSkills = json_decode($request->skills, true);
            if (is_array($decodedSkills)) {
                $skills = $decodedSkills;
            }
        } elseif ($request->has('skills') && is_array($request->skills)) {
            $skills = $request->skills;
        }

        // Validate skills array
        if (!is_array($skills)) {
            $skills = [];
        }

        // Validate each skill
        foreach ($skills as $skill) {
            if (!is_string($skill) || strlen($skill) > 50) {
                return back()->withErrors(['skills' => 'Each skill must be a string with maximum 50 characters.']);
            }
        }

        \Log::info('Skills data', ['skills' => $skills, 'user_id' => $user->id]);

        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create([
                'bio' => '',
                'skills' => [],
                'is_verified' => false,
            ]);
        }

        $user->profile()->update([
            'bio' => $request->bio,
            'skills' => $skills,
            'location' => $request->location,
            'portfolio_url' => $request->portfolio_url,
        ]);

        Session::put('onboarding_step', 4);
        \Log::info('Profile setup completed, redirecting to step 4', ['user_id' => $user->id, 'new_step' => 4, 'session_step' => Session::get('onboarding_step')]);
        return redirect()->route('onboarding.step', 4)->with('success', 'Profile updated successfully!');
    }

    private function processKycVerification(Request $request)
    {
        // For demo purposes, we'll mark KYC as pending
        // In production, this would integrate with KYC services

        $user = Auth::user();
        $user->kyc()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'pending',
                'submitted_at' => now(),
                'documents' => [],
            ]
        );

        Session::put('onboarding_step', 5);
        return redirect()->route('onboarding.step', 5);
    }

    private function processCompletion(Request $request)
    {
        $user = Auth::user();
        $user->markOnboardingAsCompleted();

        Session::forget('onboarding_step');

        // Redirect to role-specific dashboard
        return redirect()->route($user->current_role . '.dashboard');
    }

    public function skipToStep($step)
    {
        Session::put('onboarding_step', $step);
        return redirect()->route('onboarding.step', $step);
    }

    private function canAccessStep($user, $step)
    {
        // For demo, allow access to any step
        // In production, you might want to check completion status
        return true;
    }
}