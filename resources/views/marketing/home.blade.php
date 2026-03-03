<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiwi | Unified SaaS for School, Hospital, Property and POS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --tiwi-bg: #f1f3f8;
            --tiwi-ink: #0f1828;
            --tiwi-body: #273347;
            --tiwi-muted: #5f6e82;
            --tiwi-border: #d9dee8;
            --tiwi-brand: #e30613;
            --tiwi-foot: #343238;
            --tiwi-foot-muted: #d5d6db;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--tiwi-ink);
            background: var(--tiwi-bg);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1200px, 92%);
            margin-inline: auto;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #fff;
            border-bottom: 1px solid var(--tiwi-border);
        }

        .topbar-inner {
            min-height: 84px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .brand-badge {
            display: inline-grid;
            grid-auto-flow: column;
            gap: 4px;
            align-items: center;
        }

        .shape {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 2px solid currentColor;
            transform: rotate(-9deg);
        }

        .shape.s1 { color: #e6383f; }
        .shape.s2 { color: #1f9d53; transform: rotate(15deg); }
        .shape.s3 { color: #2d72b8; }
        .shape.s4 { color: #f0ac25; transform: rotate(1deg); }

        .brand-word {
            font-size: 11px;
            letter-spacing: .5em;
            text-transform: uppercase;
            color: #374455;
            margin-top: 3px;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 30px;
            font-weight: 600;
            font-size: 19px;
            color: #111d2f;
        }

        .main-nav a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color .2s ease;
        }

        .main-nav a:hover {
            color: var(--tiwi-brand);
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 17px;
        }

        .icon-btn {
            width: 34px;
            height: 34px;
            border: 1px solid var(--tiwi-border);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #243145;
            background: #fff;
        }

        .top-signin {
            color: var(--tiwi-brand);
            font-weight: 700;
        }

        .top-signup {
            color: var(--tiwi-brand);
            border: 1px solid var(--tiwi-brand);
            border-radius: 6px;
            padding: 10px 20px;
            font-weight: 700;
            transition: background .2s ease, color .2s ease;
        }

        .top-signup:hover {
            background: var(--tiwi-brand);
            color: #fff;
        }

        .hero {
            padding: 70px 0 64px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 430px;
            gap: 48px;
            align-items: start;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(2.2rem, 6vw, 4.2rem);
            line-height: 1.08;
            letter-spacing: -0.03em;
            max-width: 14ch;
            color: #060c15;
        }

        .hero-accent {
            width: 56px;
            height: 4px;
            margin: 28px 0 30px;
            border-radius: 999px;
            background: var(--tiwi-brand);
        }

        .hero p {
            margin: 0;
            font-size: clamp(1.16rem, 1.75vw, 1.95rem);
            line-height: 1.55;
            color: var(--tiwi-body);
            max-width: 27ch;
        }

        .hero-actions {
            margin-top: 42px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 8px;
            padding: 15px 30px;
            font-weight: 800;
            font-size: 1.05rem;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--tiwi-brand);
            color: #fff;
        }

        .btn-primary:hover {
            background: #c90410;
        }

        .btn-ghost {
            background: #fff;
            border-color: var(--tiwi-border);
            color: #1c283a;
        }

        .btn-ghost:hover {
            border-color: #bcc5d4;
        }

        .featured {
            background: #fff;
            border: 1px solid var(--tiwi-border);
            border-radius: 16px;
            padding: 30px 28px;
        }

        .featured h2 {
            margin: 0 0 18px;
            font-size: .92rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #2f3b4f;
        }

        .featured-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 18px;
        }

        .featured-item {
            display: grid;
            grid-template-columns: 42px 1fr auto;
            gap: 14px;
            align-items: start;
            padding: 8px 0;
        }

        .app-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #f4f7ff;
            color: #1f5fa3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .featured-item strong {
            display: block;
            font-size: 1.55rem;
            letter-spacing: -0.02em;
            line-height: 1.1;
            color: #111b2b;
        }

        .featured-item span {
            margin-top: 4px;
            display: block;
            font-size: 1.04rem;
            color: #3c475a;
            line-height: 1.45;
        }

        .app-arrow {
            font-size: 1.9rem;
            color: #8b95a8;
            line-height: 1;
            margin-top: 4px;
            transition: transform .2s ease, color .2s ease;
        }

        .featured-item:hover .app-arrow {
            color: var(--tiwi-brand);
            transform: translateX(3px);
        }

        .insight-band {
            padding: 0 0 72px;
        }

        .insight-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .insight {
            background: #fff;
            border: 1px solid var(--tiwi-border);
            border-radius: 14px;
            padding: 22px;
        }

        .insight h3 {
            margin: 0;
            font-size: 1.05rem;
            color: #2c384c;
        }

        .insight p {
            margin: 9px 0 0;
            color: #49576e;
            line-height: 1.55;
            font-size: .96rem;
        }

        .site-footer {
            background: var(--tiwi-foot);
            border-top: 8px solid #365f78;
            padding: 52px 0 56px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 34px;
        }

        .footer-col h4 {
            margin: 0 0 14px;
            color: #f5f6f8;
            font-size: 2rem;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .footer-col ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .footer-col li a {
            color: var(--tiwi-foot-muted);
            font-size: 1.02rem;
            line-height: 1.35;
            transition: color .2s ease;
        }

        .footer-col li a:hover {
            color: #fff;
        }

        .mobile-links {
            display: none;
            margin-top: 14px;
            gap: 8px;
            flex-wrap: wrap;
        }

        .mobile-links a {
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid var(--tiwi-border);
            font-size: .86rem;
            font-weight: 600;
            color: #223047;
            background: #fff;
        }

        @media (max-width: 1150px) {
            .main-nav {
                display: none;
            }

            .mobile-links {
                display: flex;
            }

            .topbar-inner {
                align-items: flex-start;
                flex-direction: column;
                padding: 16px 0;
                gap: 10px;
            }

            .top-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 1060px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 26px;
            }

            .hero h1,
            .hero p {
                max-width: none;
            }

            .featured {
                width: 100%;
            }

            .insight-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .top-actions {
                gap: 10px;
                flex-wrap: wrap;
                justify-content: flex-start;
            }

            .top-signup {
                padding: 8px 14px;
            }

            .hero {
                padding-top: 44px;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .featured-item strong {
                font-size: 1.22rem;
            }

            .featured-item span {
                font-size: .96rem;
            }

            .insight-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-col h4 {
                font-size: 1.45rem;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container">
            <div class="topbar-inner">
                <div>
                    <a href="{{ route('home') }}" class="brand" aria-label="Tiwi home">
                        <span>
                            <span class="brand-badge">
                                <i class="shape s1"></i>
                                <i class="shape s2"></i>
                                <i class="shape s3"></i>
                                <i class="shape s4"></i>
                            </span>
                            <span class="brand-word">tiwi</span>
                        </span>
                    </a>
                    <div class="mobile-links">
                        <a href="#featured-apps">Products</a>
                        <a href="#customers">Customers</a>
                        <a href="#partners">Partners</a>
                        <a href="#resources">Resources</a>
                    </div>
                </div>

                <nav class="main-nav">
                    <a href="#featured-apps">Products <span aria-hidden="true">v</span></a>
                    <a href="#customers">Customers <span aria-hidden="true">v</span></a>
                    <a href="#partners">Partners <span aria-hidden="true">v</span></a>
                    <a href="#resources">Resources <span aria-hidden="true">v</span></a>
                </nav>

                <div class="top-actions">
                    <span class="icon-btn" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="20" y1="20" x2="16.8" y2="16.8"></line>
                        </svg>
                    </span>
                    <span class="icon-btn" aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15 15 0 0 1 0 20a15 15 0 0 1 0-20Z"></path>
                        </svg>
                    </span>
                    <span>English</span>
                    @auth
                        <a href="{{ route('app.launcher') }}" class="top-signin">Open App</a>
                    @else
                        <a href="{{ route('login') }}" class="top-signin">Sign In</a>
                        <a href="{{ route('register') }}" class="top-signup">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <h1>Your life's work, powered by our life's work.</h1>
                    <div class="hero-accent"></div>
                    <p>
                        Tiwi combines School Management, Hospital Management, Property Management, and POS into one secure, subscription-based SaaS platform for growing teams.
                    </p>
                    <div class="hero-actions">
                        @auth
                            <a href="{{ route('app.launcher') }}" class="btn btn-primary">Open Dashboard <span aria-hidden="true">&gt;</span></a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started For Free <span aria-hidden="true">&gt;</span></a>
                            <a href="{{ route('pricing') }}" class="btn btn-ghost">View Pricing</a>
                        @endauth
                    </div>
                </div>

                <aside class="featured" id="featured-apps">
                    <h2>Featured Apps</h2>
                    <ul class="featured-list">
                        <li>
                            <a class="featured-item" href="{{ route('marketing.app', 'school-management') }}">
                                <span class="app-icon">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none">
                                        <path d="M4 9.5 12 5l8 4.5-8 4.5-8-4.5Z" stroke="currentColor" stroke-width="1.7"/>
                                        <path d="M7 12.4V16c0 1.1 2.2 2.4 5 2.4s5-1.3 5-2.4v-3.6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span>
                                    <strong>School</strong>
                                    <span>Admission, classes, fee invoicing, and payment tracking.</span>
                                </span>
                                <span class="app-arrow" aria-hidden="true">&gt;</span>
                            </a>
                        </li>
                        <li>
                            <a class="featured-item" href="{{ route('marketing.app', 'hospital-management') }}">
                                <span class="app-icon">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none">
                                        <rect x="4" y="4" width="16" height="16" rx="4" stroke="currentColor" stroke-width="1.7"></rect>
                                        <path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"></path>
                                    </svg>
                                </span>
                                <span>
                                    <strong>Hospital</strong>
                                    <span>Patient records, appointments, visits, bills, and collections.</span>
                                </span>
                                <span class="app-arrow" aria-hidden="true">&gt;</span>
                            </a>
                        </li>
                        <li>
                            <a class="featured-item" href="{{ route('marketing.app', 'property-management') }}">
                                <span class="app-icon">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none">
                                        <path d="M3 11 12 4l9 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"></path>
                                        <path d="M6 10.5V20h12v-9.5" stroke="currentColor" stroke-width="1.7"></path>
                                    </svg>
                                </span>
                                <span>
                                    <strong>Property</strong>
                                    <span>Units, leases, rent invoices, arrears, and maintenance workflow.</span>
                                </span>
                                <span class="app-arrow" aria-hidden="true">&gt;</span>
                            </a>
                        </li>
                        <li>
                            <a class="featured-item" href="{{ route('marketing.app', 'point-of-sale-shop') }}">
                                <span class="app-icon">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none">
                                        <rect x="5" y="6" width="14" height="12" rx="2.5" stroke="currentColor" stroke-width="1.7"></rect>
                                        <path d="M9 10h6M9 13h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"></path>
                                    </svg>
                                </span>
                                <span>
                                    <strong>Point of Sale</strong>
                                    <span>Products, stock, checkout, receipts, and daily sales insights.</span>
                                </span>
                                <span class="app-arrow" aria-hidden="true">&gt;</span>
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="insight-band" id="customers">
            <div class="container">
                <div class="insight-grid">
                    <article class="insight">
                        <h3>One Admin Dashboard</h3>
                        <p>Control all four modules from a single admin panel while each module runs independently by feature scope.</p>
                    </article>
                    <article class="insight">
                        <h3>Tenant Data Isolation</h3>
                        <p>Every module record is tenant-scoped to keep customer data segmented within one shared MySQL database.</p>
                    </article>
                    <article class="insight">
                        <h3>Flexible Billing</h3>
                        <p>Per-app monthly pricing with trial support, invoices, and payment records for subscription lifecycle control.</p>
                    </article>
                    <article class="insight" id="partners">
                        <h3>Fast Onboarding</h3>
                        <p>Users can start from any app URL and continue registration with that module pre-selected in onboarding.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer" id="resources">
        <div class="container footer-grid">
            <section class="footer-col" id="footer-products">
                <h4>Products</h4>
                <ul>
                    <li><a href="{{ route('marketing.app', 'school-management') }}">School Management System</a></li>
                    <li><a href="{{ route('marketing.app', 'hospital-management') }}">Hospital Management System</a></li>
                    <li><a href="{{ route('marketing.app', 'property-management') }}">Property Management System</a></li>
                    <li><a href="{{ route('marketing.app', 'point-of-sale-shop') }}">POS System</a></li>
                    <li><a href="{{ route('pricing') }}">Per-App Pricing</a></li>
                </ul>
            </section>
            <section class="footer-col">
                <h4>Services</h4>
                <ul>
                    <li><a href="{{ route('pricing') }}">Implementation Setup</a></li>
                    <li><a href="{{ route('pricing') }}">Data Migration</a></li>
                    <li><a href="{{ route('pricing') }}">Training and Onboarding</a></li>
                    <li><a href="{{ route('pricing') }}">Support Services</a></li>
                    <li><a href="{{ route('pricing') }}">Custom Reports</a></li>
                </ul>
            </section>
            <section class="footer-col">
                <h4>Partners</h4>
                <ul>
                    <li><a href="{{ route('pricing') }}">Implementation Partners</a></li>
                    <li><a href="{{ route('pricing') }}">Solution Providers</a></li>
                    <li><a href="{{ route('pricing') }}">Developers</a></li>
                    <li><a href="{{ route('pricing') }}">Accountants</a></li>
                    <li><a href="{{ route('pricing') }}">Channel Referrals</a></li>
                </ul>
            </section>
            <section class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="{{ route('home') }}">About Tiwi</a></li>
                    <li><a href="{{ route('pricing') }}">Careers</a></li>
                    <li><a href="{{ route('pricing') }}">Contact</a></li>
                    <li><a href="{{ route('pricing') }}">Security</a></li>
                    <li><a href="{{ route('pricing') }}">System Availability</a></li>
                </ul>
            </section>
            <section class="footer-col">
                <h4>Resource Center</h4>
                <ul>
                    <li><a href="{{ route('pricing') }}">Data Sheets</a></li>
                    <li><a href="{{ route('pricing') }}">Product Demo</a></li>
                    <li><a href="{{ route('pricing') }}">Business Guides</a></li>
                    <li><a href="{{ route('pricing') }}">Tax and Billing Notes</a></li>
                    <li><a href="{{ route('pricing') }}">Email Updates</a></li>
                </ul>
            </section>
        </div>
    </footer>
</body>
</html>


