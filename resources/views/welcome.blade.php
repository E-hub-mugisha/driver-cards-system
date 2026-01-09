<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Driver Management System') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
        }

        .hero-card {
            border-radius: 1rem;
        }

        .icon-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: #0d6efd;
            color: #fff;
        }

        .carousel-item img {
            max-height: 260px;
            object-fit: contain;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-lg-10">
            <div class="card hero-card shadow-lg">
                <div class="row g-0">

                    <!-- ================= LEFT SECTION ================= -->
                    <div class="col-md-6 p-5">
                        <h1 class="fw-bold mb-3">
                            Driver & Company Management System
                        </h1>

                        <p class="text-muted mb-4">
                            A centralized platform for managing drivers, tracking behaviors,
                            incidents, payroll, and generating analytical reports — all in one place.
                        </p>

                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle me-3">🚗</div>
                                <div>
                                    <strong>Driver Management</strong><br>
                                    <small class="text-muted">Profiles, behaviors & incidents</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle me-3">📊</div>
                                <div>
                                    <strong>Reports & Analytics</strong><br>
                                    <small class="text-muted">Monthly insights & performance tracking</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3">💰</div>
                                <div>
                                    <strong>Payroll Management</strong><br>
                                    <small class="text-muted">Automated payroll & deductions</small>
                                </div>
                            </div>
                        </div>

                        <!-- ================= AUTH BUTTONS ================= -->
                        <div class="d-flex gap-3">
                            @auth
                            @if(auth()->user()->type == 'admin')
                            <a href="{{ route('admin.home') }}" class="btn btn-success w-100 fw-bold">Go to Admin Dashboard</a>
                            @elseif(auth()->user()->type == 'manager')
                            <a href="{{ route('company.dashboard') }}" class="btn btn-success w-100 fw-bold">Manager Dashboard</a>
                            @else
                            <a href="{{ route('driver.index') }}" class="btn btn-success w-100 fw-bold">Driver Dashboard</a>
                            @endif
                            @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">
                                Register
                            </a>
                            @endauth
                        </div>
                    </div>

                    <!-- ================= RIGHT SECTION (CAROUSEL) ================= -->
                    <div class="col-md-6 d-none d-md-flex align-items-center bg-light rounded-end">
                        <div class="w-100 p-4">

                            <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner text-center">

                                    <div class="carousel-item active">
                                        <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" class="img-fluid mb-3">
                                        <h5 class="fw-semibold">Smart Driver Management</h5>
                                        <p class="text-muted">
                                            Track drivers, behaviors, and incidents with clarity.
                                        </p>
                                    </div>

                                    <div class="carousel-item">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3050/3050525.png" class="img-fluid mb-3">
                                        <h5 class="fw-semibold">Powerful Reports</h5>
                                        <p class="text-muted">
                                            Download, analyze, and share detailed performance reports.
                                        </p>
                                    </div>

                                    <div class="carousel-item">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" class="img-fluid mb-3">
                                        <h5 class="fw-semibold">Payroll Automation</h5>
                                        <p class="text-muted">
                                            Generate payroll with deductions and approvals seamlessly.
                                        </p>
                                    </div>

                                </div>

                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <p class="text-center text-white mt-4 small">
                © {{ now()->year }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>

</body>

</html>