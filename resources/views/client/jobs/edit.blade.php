@extends('layouts.client')

@section('title', 'Edit Job')

@section('page-title', 'Edit Job')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 fw-bold">Edit Job</h2>
                    <p class="text-muted mb-0">Update your job posting details</p>
                </div>
                <a href="{{ route('client.jobs.show', $job->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Job
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('client.jobs.update', $job->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <!-- Job Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                Job Title <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                placeholder="e.g., Build a WordPress Website"
                                value="{{ old('title', $job->title) }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Choose a clear, descriptive title that explains what you need</div>
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="form-label fw-semibold">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="Web Development" {{ old('category', $job->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                <option value="Mobile Development" {{ old('category', $job->category) == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                                <option value="Design" {{ old('category', $job->category) == 'Design' ? 'selected' : '' }}>Design & Creative</option>
                                <option value="Writing" {{ old('category', $job->category) == 'Writing' ? 'selected' : '' }}>Writing & Content</option>
                                <option value="Marketing" {{ old('category', $job->category) == 'Marketing' ? 'selected' : '' }}>Marketing & Sales</option>
                                <option value="Data Entry" {{ old('category', $job->category) == 'Data Entry' ? 'selected' : '' }}>Data Entry & Admin</option>
                                <option value="SEO" {{ old('category', $job->category) == 'SEO' ? 'selected' : '' }}>SEO & Digital Marketing</option>
                                <option value="Video & Animation" {{ old('category', $job->category) == 'Video & Animation' ? 'selected' : '' }}>Video & Animation</option>
                                <option value="Translation" {{ old('category', $job->category) == 'Translation' ? 'selected' : '' }}>Translation & Languages</option>
                                <option value="Other" {{ old('category', $job->category) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Job Description <span class="text-danger">*</span>
                            </label>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="8"
                                placeholder="Describe your project in detail... Include objectives, deliverables, and any specific requirements"
                                required
                            >{{ old('description', $job->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Be specific about what you need. Include goals, requirements, and expected deliverables</div>
                        </div>

                        <!-- Skills Required -->
                        <div class="mb-4">
                            <label for="skills_required" class="form-label fw-semibold">
                                Required Skills
                            </label>
                            <input
                                type="text"
                                class="form-control @error('skills_required') is-invalid @enderror"
                                id="skills_required"
                                name="skills_required"
                                placeholder="e.g., PHP, Laravel, Vue.js, MySQL"
                                value="{{ old('skills_required', is_array($job->skills_required) ? implode(', ', $job->skills_required) : '') }}"
                            >
                            @error('skills_required')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Separate skills with commas. This helps match you with the right freelancers</div>
                        </div>
                    </div>
                </div>

                <!-- Budget & Timeline -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="bi bi-cash-stack me-2 text-success"></i>Budget & Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Budget Range -->
                            <div class="col-md-6 mb-4">
                                <label for="budget_min" class="form-label fw-semibold">
                                    Minimum Budget <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input
                                        type="number"
                                        class="form-control @error('budget_min') is-invalid @enderror"
                                        id="budget_min"
                                        name="budget_min"
                                        placeholder="500"
                                        min="1"
                                        step="1"
                                        value="{{ old('budget_min', $job->budget_min) }}"
                                        required
                                    >
                                    @error('budget_min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="budget_max" class="form-label fw-semibold">
                                    Maximum Budget <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input
                                        type="number"
                                        class="form-control @error('budget_max') is-invalid @enderror"
                                        id="budget_max"
                                        name="budget_max"
                                        placeholder="1000"
                                        min="1"
                                        step="1"
                                        value="{{ old('budget_max', $job->budget_max) }}"
                                        required
                                    >
                                    @error('budget_max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6 mb-4">
                                <label for="duration" class="form-label fw-semibold">
                                    Project Duration
                                </label>
                                <select class="form-select @error('duration') is-invalid @enderror" id="duration" name="duration">
                                    <option value="">Select duration</option>
                                    <option value="Less than 1 week" {{ old('duration', $job->duration) == 'Less than 1 week' ? 'selected' : '' }}>Less than 1 week</option>
                                    <option value="1-2 weeks" {{ old('duration', $job->duration) == '1-2 weeks' ? 'selected' : '' }}>1-2 weeks</option>
                                    <option value="2-4 weeks" {{ old('duration', $job->duration) == '2-4 weeks' ? 'selected' : '' }}>2-4 weeks</option>
                                    <option value="1-3 months" {{ old('duration', $job->duration) == '1-3 months' ? 'selected' : '' }}>1-3 months</option>
                                    <option value="3-6 months" {{ old('duration', $job->duration) == '3-6 months' ? 'selected' : '' }}>3-6 months</option>
                                    <option value="More than 6 months" {{ old('duration', $job->duration) == 'More than 6 months' ? 'selected' : '' }}>More than 6 months</option>
                                </select>
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-6 mb-4">
                                <label for="expires_at" class="form-label fw-semibold">
                                    Job Expires On
                                </label>
                                <input
                                    type="date"
                                    class="form-control @error('expires_at') is-invalid @enderror"
                                    id="expires_at"
                                    name="expires_at"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('expires_at', $job->expires_at ? $job->expires_at->format('Y-m-d') : '') }}"
                                >
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">When should this job listing close for new bids?</div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label fw-semibold">
                                    Job Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="draft" {{ old('status', $job->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="open" {{ old('status', $job->status) == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ old('status', $job->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status', $job->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="closed" {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('client.jobs.show', $job->id) }}" class="btn btn-link text-muted">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update Job
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Job Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-info-circle text-primary me-2"></i>Job Information
                    </h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Created</span>
                        <strong>{{ $job->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Last Updated</span>
                        <strong>{{ $job->updated_at->diffForHumans() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Bids</span>
                        <strong>{{ $job->bids->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-info">{{ ucfirst($job->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i>Update Tips
                    </h6>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-info me-2 mt-1"></i>
                            <small>Make sure changes don't affect existing bids</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-info me-2 mt-1"></i>
                            <small>Notify active bidders if requirements change</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill text-info me-2 mt-1"></i>
                            <small>Changing status may affect job visibility</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 0.75rem;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5568d3 0%, #65398b 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
</style>

<script>
// Validate budget range
document.getElementById('budget_max').addEventListener('input', function() {
    const minBudget = parseFloat(document.getElementById('budget_min').value) || 0;
    const maxBudget = parseFloat(this.value) || 0;

    if (maxBudget < minBudget) {
        this.setCustomValidity('Maximum budget must be greater than minimum budget');
    } else {
        this.setCustomValidity('');
    }
});
</script>
@endsection
