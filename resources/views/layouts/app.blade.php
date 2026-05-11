<!DOCTYPE html>
<html lang="en" class="js">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="utf-8">
  <meta name="author" content="Your Company">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Professional Fleet Management System">
  <meta name="theme-color" content="#00ADEE">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
  
  <title>@yield('title') | {{ config('app.name') }}</title>

  <!-- Original DashLite Styles (keeping for compatibility) -->
  <link rel="stylesheet" href="{{ asset('assets/css/dashlitee1e3.css?ver=3.2.4') }}">
  <link id="skin-default" rel="stylesheet" href="{{ asset('/assets/css/themee1e3.css?ver=3.2.4') }}">

  <!-- Modern Enhancement Styles -->
  <style>
    :root {
      --primary: #00ADEE;
      --accent: #E3B228;
      --dark: #1a1f36;
      --light: #f8f9fb;
      --gray-50: #f9fafb;
      --gray-100: #f3f4f6;
      --gray-200: #e5e7eb;
      --gray-300: #d1d5db;
      --gray-400: #9ca3af;
      --gray-500: #6b7280;
      --gray-600: #4b5563;
      --gray-700: #374151;
      --gray-800: #1f2937;
      --white: #ffffff;
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
      --shadow-lg: 0 10px 32px rgba(0, 0, 0, 0.15);
    }

    /* ===== GLOBAL OVERRIDES ===== */
    * {
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background: var(--light);
      color: var(--dark);
    }

    /* ===== APP WRAPPER ===== */
    .nk-app-root {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .nk-main {
      display: flex;
      flex: 1;
      overflow: hidden;
    }

    .nk-wrap {
      flex: 1;
      display: flex;
      flex-direction: column;
      margin-left: 280px;
      margin-top: 70px;
      background: var(--light);
      overflow-y: auto;
    }

    /* ===== CONTENT AREA ===== */
    .nk-content {
      flex: 1;
      padding: 32px;
      overflow-y: auto;
      background: var(--light);
    }

    /* ===== SCROLLBAR STYLING ===== */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: var(--gray-100);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--gray-300);
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--gray-400);
    }

    /* ===== CARD ENHANCEMENTS ===== */
    .card {
      background: var(--white);
      border: 1px solid var(--gray-200);
      border-radius: 12px;
      box-shadow: var(--shadow-sm);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card:hover {
      border-color: var(--primary);
      box-shadow: var(--shadow-md);
      transform: translateY(-2px);
    }

    .card-inner {
      padding: 24px;
    }

    .card-inner-sm {
      padding: 16px;
    }

    /* ===== BUTTON ENHANCEMENTS ===== */
    .btn {
      border-radius: 8px;
      font-weight: 600;
      font-size: 13px;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
      text-decoration: none;
    }

    .btn-primary,
    .btn-success {
      background: var(--primary);
      color: var(--white);
    }

    .btn-primary:hover,
    .btn-success:hover {
      background: #0094d4;
      box-shadow: 0 10px 32px rgba(0, 173, 238, 0.2);
      transform: translateY(-2px);
    }

    .btn-white {
      background: var(--white);
      border: 1px solid var(--gray-300);
      color: var(--dark);
    }

    .btn-white:hover {
      border-color: var(--primary);
      background: var(--primary-10);
      color: var(--primary);
    }

    .btn-light {
      background: var(--gray-100);
      color: var(--dark);
    }

    .btn-light:hover {
      background: var(--gray-200);
    }

    /* ===== BADGE ENHANCEMENTS ===== */
    .badge {
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }

    .badge-dot {
      padding-left: 6px;
    }

    .badge-dot::before {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      margin-right: 6px;
    }

    .badge-success {
      background: rgba(16, 185, 129, 0.15);
      color: #10b981;
    }

    .badge-warning {
      background: rgba(245, 158, 11, 0.15);
      color: #f59e0b;
    }

    .badge-danger {
      background: rgba(239, 68, 68, 0.15);
      color: #ef4444;
    }

    .badge-info {
      background: rgba(59, 130, 246, 0.15);
      color: #3b82f6;
    }

    /* ===== TABLE ENHANCEMENTS ===== */
    .table {
      border-collapse: collapse;
      width: 100%;
      margin: 0;
    }

    .table thead th {
      background: var(--gray-50);
      border-bottom: 2px solid var(--gray-200);
      padding: 12px 16px;
      font-weight: 700;
      color: var(--gray-700);
      text-transform: uppercase;
      letter-spacing: 0.3px;
      font-size: 11px;
    }

    .table tbody td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--gray-100);
      font-size: 13px;
    }

    .table tbody tr {
      transition: background 0.2s ease;
    }

    .table tbody tr:hover {
      background: var(--gray-50);
    }

    .table tbody tr:last-child td {
      border-bottom: none;
    }

    /* ===== AVATAR ENHANCEMENTS ===== */
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--white);
      font-weight: 600;
      font-size: 13px;
      background: linear-gradient(135deg, var(--primary), #0094d4);
      flex-shrink: 0;
    }

    .user-avatar-sm {
      width: 32px;
      height: 32px;
      font-size: 12px;
    }

    .user-avatar-lg {
      width: 48px;
      height: 48px;
      font-size: 14px;
    }

    /* ===== DROPDOWN ENHANCEMENTS ===== */
    .dropdown-menu {
      background: var(--white);
      border: 1px solid var(--gray-200);
      border-radius: 8px;
      box-shadow: var(--shadow-lg);
      padding: 4px;
      animation: slideDown 0.2s ease;
    }

    .dropdown-menu .dropdown-item {
      padding: 10px 14px;
      font-size: 13px;
      color: var(--dark);
      border-radius: 6px;
      transition: all 0.2s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .dropdown-menu .dropdown-item:hover {
      background: var(--primary-10);
      color: var(--primary);
    }

    .dropdown-menu .dropdown-item em {
      font-size: 14px;
    }

    /* ===== FORM ENHANCEMENTS ===== */
    .form-control {
      border-radius: 8px;
      border: 1px solid var(--gray-300);
      padding: 10px 12px;
      font-size: 13px;
      transition: all 0.2s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(0, 173, 238, 0.1);
    }

    /* ===== ALERT ENHANCEMENTS ===== */
    .alert {
      border-radius: 8px;
      border: 1px solid transparent;
      padding: 16px;
      margin-bottom: 16px;
      animation: slideDown 0.3s ease;
    }

    .alert-success {
      background: rgba(16, 185, 129, 0.1);
      border-color: #10b981;
      color: #10b981;
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.1);
      border-color: #ef4444;
      color: #ef4444;
    }

    .alert-warning {
      background: rgba(245, 158, 11, 0.1);
      border-color: #f59e0b;
      color: #f59e0b;
    }

    .alert-info {
      background: rgba(59, 130, 246, 0.1);
      border-color: #3b82f6;
      color: #3b82f6;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* ===== TITLE & HEADING ENHANCEMENTS ===== */
    .nk-block-head-content h3 {
      font-size: 24px;
      font-weight: 700;
      color: var(--dark);
      margin: 0 0 4px 0;
      letter-spacing: -0.5px;
    }

    .nk-block-head-content .nk-block-des {
      font-size: 13px;
      color: var(--gray-600);
    }

    /* ===== SECTION SPACING ===== */
    .nk-block {
      margin-bottom: 32px;
    }

    .nk-block-head {
      margin-bottom: 24px;
    }

    /* ===== TEXT UTILITIES ===== */
    .text-soft {
      color: var(--gray-600);
    }

    .text-muted {
      color: var(--gray-500);
    }

    .text-primary {
      color: var(--primary);
    }

    .text-accent {
      color: var(--accent);
    }

    .text-success {
      color: #10b981;
    }

    .text-warning {
      color: #f59e0b;
    }

    .text-danger {
      color: #ef4444;
    }

    /* ===== UTILITY CLASSES ===== */
    .d-none {
      display: none !important;
    }

    .d-block {
      display: block !important;
    }

    .d-flex {
      display: flex !important;
    }

    .d-grid {
      display: grid !important;
    }

    .d-sm-inline {
      display: none !important;
    }

    .d-md-inline {
      display: none !important;
    }

    .d-lg-inline {
      display: none !important;
    }

    .me-n1 {
      margin-right: -4px;
    }

    .me-1 {
      margin-right: 4px;
    }

    .mb-0 {
      margin-bottom: 0;
    }

    .mb-2 {
      margin-bottom: 8px;
    }

    .ms-1 {
      margin-left: 4px;
    }

    .g-3 {
      gap: 16px;
    }

    .g-4 {
      gap: 24px;
    }

    .gap-5 {
      gap: 32px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1199px) {
      .nk-wrap {
        margin-left: 0;
      }

      .d-xl-none {
        display: block !important;
      }

      .d-xl-inline-flex {
        display: none !important;
      }
    }

    @media (min-width: 576px) {
      .d-sm-inline {
        display: inline !important;
      }

      .d-sm-none {
        display: none !important;
      }
    }

    @media (min-width: 768px) {
      .d-md-inline {
        display: inline !important;
      }

      .d-md-block {
        display: block !important;
      }

      .d-md-none {
        display: none !important;
      }
    }

    @media (min-width: 992px) {
      .d-lg-inline {
        display: inline !important;
      }

      .d-lg-block {
        display: block !important;
      }

      .d-lg-none {
        display: none !important;
      }
    }

    @media (max-width: 768px) {
      .nk-content {
        padding: 20px 16px;
      }

      .card-inner {
        padding: 16px;
      }

      .nk-block-head-content h3 {
        font-size: 18px;
      }

      .user-avatar {
        width: 36px;
        height: 36px;
        font-size: 12px;
      }

      .table thead th,
      .table tbody td {
        padding: 10px 12px;
        font-size: 12px;
      }
    }

    /* ===== TRANSITIONS ===== */
    * {
      transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    /* ===== CUSTOM GRADIENTS ===== */
    .bg-gradient-primary {
      background: linear-gradient(135deg, var(--primary), #0094d4);
    }

    .bg-gradient-accent {
      background: linear-gradient(135deg, var(--accent), #d4a420);
    }

    .text-white {
      color: var(--white);
    }

    /* ===== MODERN HOVER EFFECTS ===== */
    .nk-tb-item:hover {
      background: var(--gray-50);
    }

    /* ===== LINK STYLES ===== */
    .link {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .link:hover {
      color: #0094d4;
      text-decoration: underline;
    }

    /* ===== CUSTOM PRIMARY COLOR OVERRIDES ===== */
    .bg-primary {
      background-color: var(--primary) !important;
    }

    .bg-primary-dim {
      background-color: rgba(0, 173, 238, 0.1);
    }

    .text-primary {
      color: var(--primary) !important;
    }

    .border-primary {
      border-color: var(--primary) !important;
    }

    /* ===== CUSTOM ACCENT COLOR OVERRIDES ===== */
    .bg-accent {
      background-color: var(--accent) !important;
    }

    .text-accent {
      color: var(--accent) !important;
    }
  </style>

  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-91615293-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-91615293-4');
  </script>
</head>

<body class="nk-body bg-lighter npc-general has-sidebar">
  <div class="nk-app-root">
    <div class="nk-main">
      {{-- SIDEBAR COMPONENT --}}
      @include('layouts.sidebar')

      {{-- MAIN WRAPPER --}}
      <div class="nk-wrap">
        {{-- HEADER COMPONENT --}}
        @include('layouts.header')
        
        {{-- ALERTS & NOTIFICATIONS --}}
        @include('sweetalert::alert')

        {{-- MAIN CONTENT --}}
        <div class="nk-content">
          @yield('content')
        </div>

        {{-- FOOTER COMPONENT --}}
        @include('layouts.footer')
      </div>
    </div>
  </div>

  {{-- SCRIPTS --}}
  <script src="{{ asset('/assets/js/bundlee1e3.js?ver=3.2.4') }}"></script>
  <script src="{{ asset('/assets/js/scriptse1e3.js?ver=3.2.4') }}"></script>
  <script src="{{ asset('/assets/js/demo-settingse1e3.js?ver=3.2.4') }}"></script>
  <script src="{{ asset('/assets/js/libs/datatable-btnse1e3.js?ver=3.2.4') }}"></script>

  {{-- CUSTOM JS FOR MODERN ENHANCEMENTS --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });

      // Add active class to current route
      const currentLocation = location.pathname;
      const menuItems = document.querySelectorAll('.nk-menu-link');
      menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
          item.classList.add('active');
        }
      });

      // Smooth transitions
      document.body.style.opacity = '1';
    });
  </script>
</body>

</html>