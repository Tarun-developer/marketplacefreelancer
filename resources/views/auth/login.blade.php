@extends('layouts.guest')

@section('title', 'Login - MarketFusion')

@section('content')
    <div class="row justify-content-center">
        <div class=" col">
            <div class="card shadow auth-card">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Sign in to your account</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input id="email" name="email" type="email" class="form-control" required placeholder="Email address">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" class="form-control" required placeholder="Password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection