@extends('layouts.guest')

@section('title', 'Register - MarketFusion')

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow auth-card">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Create your account</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input id="name" name="name" type="text" class="form-control" required placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" name="email" type="email" class="form-control" required placeholder="Email address">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" class="form-control" required placeholder="Password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required placeholder="Confirm Password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection