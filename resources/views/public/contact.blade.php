@extends('layouts.guest')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Contact Us</h1>
            <p class="lead text-muted">Get in touch with our team for support or inquiries</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <form action="#" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select" id="subject" name="subject" required>
                                <option value="">Choose a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Technical Support</option>
                                <option value="billing">Billing Question</option>
                                <option value="partnership">Partnership</option>
                                <option value="feedback">Feedback</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h3 class="mb-4">Get in Touch</h3>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <i class="bi bi-envelope text-primary fs-1 mb-3"></i>
                    <h5>Email</h5>
                    <p class="text-muted">support@marketfusion.com</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <i class="bi bi-telephone text-primary fs-1 mb-3"></i>
                    <h5>Phone</h5>
                    <p class="text-muted">+1 (555) 123-4567</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <i class="bi bi-geo-alt text-primary fs-1 mb-3"></i>
                    <h5>Address</h5>
                    <p class="text-muted">123 Business Ave, Suite 100<br>Tech City, TC 12345</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection