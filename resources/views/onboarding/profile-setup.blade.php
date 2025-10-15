@extends('onboarding.layout')

@section('title', 'Profile Setup')

@section('content')
<div class="py-4">
    <div class="text-center mb-4">
        <h2 class="mb-3">Complete Your Profile</h2>
        <p class="text-muted">Help others understand who you are and what you do</p>
    </div>

                    <form method="POST" action="{{ route('onboarding.process') }}" class="row justify-content-center" id="profile-form">
                        @csrf

                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="col-12 mb-4">
                                <div class="alert alert-danger">
                                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Basic Information</h5>

                    <!-- Bio -->
                    <div class="mb-4">
                        <label for="bio" class="form-label">Tell us about yourself <span class="text-muted">(Optional)</span></label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Describe your experience, skills, and what makes you unique...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This will be visible on your public profile</div>
                    </div>

                    <!-- Skills -->
                    <div class="mb-4">
                        <label for="skills" class="form-label">Skills & Expertise <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control @error('skills') is-invalid @enderror" id="skills" name="skills_input" placeholder="e.g., PHP, Laravel, React, Design">
                        <input type="hidden" name="skills" id="skills-hidden" value="{{ old('skills', json_encode(old('skills', $user->profile->skills ?? []))) }}">
                        <div class="form-text">Type skills and press Enter to add them</div>
                        <div id="skills-container" class="mt-2">
                            @if($user->profile && $user->profile->skills)
                                @foreach($user->profile->skills as $skill)
                                    <span class="badge bg-secondary me-1 mb-1 skill-tag" data-skill="{{ $skill }}">
                                        {{ $skill }} <button type="button" class="btn-close btn-close-white ms-1" onclick="removeSkill('{{ $skill }}')"></button>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="form-label">Location <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $user->profile->location ?? '') }}" placeholder="City, Country">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Portfolio URL -->
                    <div class="mb-4">
                        <label for="portfolio_url" class="form-label">Portfolio/Website <span class="text-muted">(Optional)</span></label>
                        <input type="url" class="form-control @error('portfolio_url') is-invalid @enderror" id="portfolio_url" name="portfolio_url" value="{{ old('portfolio_url', $user->profile->portfolio_url ?? '') }}" placeholder="https://yourportfolio.com">
                        @error('portfolio_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5" id="submit-btn">
                    <i class="bi bi-person-check me-2"></i>Continue to Verification
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('profile-form').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submit-btn');
    const originalText = submitBtn.innerHTML;

    // Show loading state
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating Profile...';
    submitBtn.disabled = true;

    // The form will submit normally, but we can add additional handling here if needed
});
</script>

<script>
let skills = @json($user->profile->skills ?? []);

document.getElementById('skills').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addSkill(this.value.trim());
        this.value = '';
    }
});

function addSkill(skill) {
    if (skill && !skills.includes(skill)) {
        skills.push(skill);
        updateSkillsDisplay();
    }
}

function removeSkill(skillToRemove) {
    skills = skills.filter(s => s !== skillToRemove);
    updateSkillsDisplay();
}

function updateSkillsDisplay() {
    const container = document.getElementById('skills-container');
    const hiddenInput = document.getElementById('skills-hidden');

    container.innerHTML = '';
    skills.forEach(skill => {
        const badge = document.createElement('span');
        badge.className = 'badge bg-secondary me-1 mb-1 skill-tag';
        badge.setAttribute('data-skill', skill);
        badge.innerHTML = `${skill} <button type="button" class="btn-close btn-close-white ms-1" onclick="removeSkill('${skill}')"></button>`;
        container.appendChild(badge);
    });

    hiddenInput.value = JSON.stringify(skills);
}

// Initialize skills from hidden input on page load
document.addEventListener('DOMContentLoaded', function() {
    const hiddenSkills = document.getElementById('skills-hidden').value;
    if (hiddenSkills) {
        try {
            skills = JSON.parse(hiddenSkills);
            updateSkillsDisplay();
        } catch (e) {
            console.error('Error parsing skills:', e);
        }
    }
});

// Handle form validation errors
@if ($errors->any())
    @foreach ($errors->all() as $error)
        console.error('Validation error: {{ $error }}');
    @endforeach
@endif
</script>
@endsection