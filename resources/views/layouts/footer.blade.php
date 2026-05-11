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
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --white: #ffffff;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 32px rgba(0, 0, 0, 0.15);
    }

    /* ============= FOOTER MODERN ============= */
    .footer-modern {
        background: linear-gradient(135deg, var(--dark) 0%, #0f1419 100%);
        border-top: 2px solid rgba(0, 173, 238, 0.2);
        padding: 40px 32px 20px;
        margin-top: auto;
        position: relative;
        overflow: hidden;
    }

    .footer-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--primary), transparent);
        opacity: 0.5;
    }

    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    /* Footer Column */
    .footer-column {
        display: flex;
        flex-direction: column;
    }

    .footer-column-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 700;
        color: var(--white);
        letter-spacing: 0.5px;
    }

    .footer-column-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(180deg, var(--primary) 0%, var(--accent) 100%);
        border-radius: 2px;
    }

    .footer-column-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .footer-column-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: inline-block;
        width: fit-content;
    }

    .footer-column-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary);
        transition: width 0.3s ease;
    }

    .footer-column-link:hover {
        color: var(--white);
    }

    .footer-column-link:hover::after {
        width: 100%;
    }

    /* About Section */
    .footer-about {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .footer-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .footer-brand-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary) 0%, #0094d4 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(0, 173, 238, 0.3);
    }

    .footer-brand-text {
        display: flex;
        flex-direction: column;
    }

    .footer-brand-name {
        font-weight: 700;
        color: var(--white);
        font-size: 14px;
        margin: 0;
    }

    .footer-brand-tagline {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.6);
        margin: 2px 0 0 0;
    }

    .footer-description {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
        margin: 0;
    }

    /* Social Links */
    .footer-socials {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .social-link {
        width: 36px;
        height: 36px;
        background: rgba(0, 173, 238, 0.15);
        border: 1px solid rgba(0, 173, 238, 0.3);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        text-decoration: none;
        font-size: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .social-link:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
        transform: translateY(-3px);
    }

    /* Footer Bottom */
    .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-copyright {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .footer-copyright a {
        color: var(--primary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-copyright a:hover {
        color: var(--accent);
    }

    .footer-legal {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .legal-link {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .legal-link:hover {
        color: var(--white);
    }

    .footer-year {
        display: inline-block;
        margin: 0 2px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-modern {
            padding: 32px 16px 16px;
        }

        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }

        .footer-legal {
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-column-title {
            font-size: 13px;
        }

        .footer-column-link {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<footer class="footer-modern">
    <div class="footer-container">
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-copyright">
                &copy; <span class="footer-year">{{ date('Y') }}</span> {{ config('app.name') }}.
                All rights reserved. | Designed by <a href="#">Your Company</a>
            </div>
            <div class="footer-legal">
                <a href="#" class="legal-link">Privacy Policy</a>
                <a href="#" class="legal-link">Terms of Service</a>
                <a href="#" class="legal-link">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>