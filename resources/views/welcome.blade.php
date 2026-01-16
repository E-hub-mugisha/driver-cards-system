<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Driver Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Glass UI Styling -->
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0b132b, #1c2541, #3a506b);
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: #fff;
        }

        .glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.35);
        }

        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
        }

        .feature-icon {
            font-size: 2.8rem;
            color: #5bc0be;
        }

        .stat-number {
            font-size: 2.4rem;
            font-weight: 700;
            color: #5bc0be;
        }

        .btn-glass {
            background: linear-gradient(135deg, #5bc0be, #3a86ff);
            color: #000;
            border-radius: 50px;
            padding: 14px 34px;
            font-weight: 600;
            border: none;
        }

        .btn-glass:hover {
            opacity: .9;
            color: #000;
        }

        footer {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="bi bi-truck-front-fill"></i> DriverMS
            </a>

            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-light px-4">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-glass">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="glass p-5">
                        <h1 class="fw-bold display-6 mb-3">
                            Intelligent Driver Management Platform
                        </h1>

                        <p class="text-light fs-5 mb-4">
                            A centralized system to manage drivers, monitor behavior,
                            generate reports, and improve fleet safety across multiple companies.
                        </p>

                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-info"></i> Multi-company scoping</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-info"></i> Behavior & incident tracking</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-info"></i> Secure role-based access</li>
                        </ul>

                        <a href="{{ route('login') }}" class="btn btn-glass me-3">
                            <i class="bi bi-box-arrow-in-right"></i> Access System
                        </a>

                        <a href="#features" class="btn btn-outline-light">
                            Explore Features
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/images/driver-dashboard.png') }}"
                        class="img-fluid rounded-4 shadow-lg"
                        alt="System Dashboard">
                </div>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4 text-center">
                @foreach ([
                ['1K+', 'Drivers Managed'],
                ['99.9%', 'System Uptime'],
                ['100%', 'Company Data Isolation'],
                ['24/7', 'Availability']
                ] as [$value, $label])
                <div class="col-md-3">
                    <div class="glass p-4">
                        <div class="stat-number">{{ $value }}</div>
                        <div class="small text-light">{{ $label }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Platform Capabilities</h2>

            <div class="row g-4">
                @foreach ([
                ['Driver Profiles', 'bi-person-vcard', 'Centralized driver records, licenses, and history'],
                ['Behavior Management', 'bi-clipboard-check', 'Log incidents, violations, and performance reports'],
                ['Company Scoping', 'bi-buildings', 'Each company sees only its own data'],
                ['PDF & Email Reports', 'bi-file-earmark-pdf', 'Export and share driver behavior reports'],
                ['Access Control', 'bi-shield-lock', 'Admins, supervisors, and staff roles'],
                ['Audit & Tracking', 'bi-clock-history', 'Full accountability and traceability']
                ] as [$title, $icon, $desc])
                <div class="col-md-4">
                    <div class="glass p-4 h-100 text-center">
                        <i class="bi {{ $icon }} feature-icon mb-3"></i>
                        <h5 class="fw-semibold">{{ $title }}</h5>
                        <p class="text-light small">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- WORKFLOW -->
    <section class="py-5">
        <div class="container">
            <div class="glass p-5">
                <h3 class="fw-bold mb-4 text-center">How It Works</h3>

                <div class="row text-center g-4">
                    <div class="col-md-3">
                        <i class="bi bi-person-plus feature-icon"></i>
                        <p class="mt-2">Register Drivers</p>
                    </div>
                    <div class="col-md-3">
                        <i class="bi bi-clipboard-data feature-icon"></i>
                        <p class="mt-2">Record Behavior</p>
                    </div>
                    <div class="col-md-3">
                        <i class="bi bi-bar-chart feature-icon"></i>
                        <p class="mt-2">Analyze Performance</p>
                    </div>
                    <div class="col-md-3">
                        <i class="bi bi-send-check feature-icon"></i>
                        <p class="mt-2">Export & Share Reports</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 text-center">
        <div class="container">
            <div class="glass p-5">
                <h2 class="fw-bold mb-3">
                    Ready to Improve Driver Accountability?
                </h2>
                <p class="text-light mb-4">
                    Start managing drivers professionally with a secure,
                    scalable, and modern system.
                </p>
                <a href="{{ route('register') }}" class="btn btn-glass btn-lg">
                    Launch Your Company
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-4 mt-5">
        <div class="container text-center text-light small">
            © {{ date('Y') }} Driver Management System · Built with Laravel · Secure & Scalable
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>