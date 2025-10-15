<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Welcome') - {{ config('app.name', 'Marketplace') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --danger-color: #f56565;
            --info-color: #4299e1;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .onboarding-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .progress-bar {
            height: 8px;
            background: #e9ecef;
            border-radius: 0;
        }

        .progress-bar .progress {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 0;
        }

        .step-indicator {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .step-indicator.active {
            background: var(--primary-color);
            color: white;
        }

        .step-indicator.completed {
            background: var(--success-color);
            color: white;
        }

        .step-indicator.pending {
            background: #e9ecef;
            color: #6c757d;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="onboarding-container">
                    <!-- Progress Header -->
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="mb-0">Welcome to {{ config('app.name') }}!</h2>
                            <small class="text-muted">Step {{ $step ?? 1 }} of 5</small>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ (($step ?? 1) / 5) * 100 }}%"></div>
                        </div>

                        <!-- Step Indicators -->
                        <div class="d-flex justify-content-between mt-3">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="text-center">
                                    <div class="step-indicator {{ $i < ($step ?? 1) ? 'completed' : ($i == ($step ?? 1) ? 'active' : 'pending') }}">
                                        {{ $i < ($step ?? 1) ? '<i class="bi bi-check"></i>' : $i }}
                                    </div>
                                    <small class="d-block mt-1 text-muted">
                                        @switch($i)
                                            @case(1) Welcome @break
                                            @case(2) Choose Role @break
                                            @case(3) Profile Setup @break
                                            @case(4) Verification @break
                                            @case(5) Complete @break
                                        @endswitch
                                    </small>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="p-4">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>