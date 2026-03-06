@php
    $moduleSelection = $selectedModule ?? old('selected_module');
    $moduleKey = is_string($moduleSelection) ? strtolower($moduleSelection) : null;

    $moduleMeta = [
        'school' => [
            'name' => 'School',
            'headline' => 'Open your school workspace in minutes',
            'description' => 'Set up admissions, classes, billing, and reporting from one secure tenant dashboard.',
            'points' => ['Fast onboarding', 'Student billing ready', 'Secure role access', 'Built-in reporting'],
        ],
        'hospital' => [
            'name' => 'Hospital',
            'headline' => 'Launch hospital operations with confidence',
            'description' => 'Manage patients, appointments, billing, and departmental workflows on a single platform.',
            'points' => ['Patient-first flow', 'Department controls', 'Billing visibility', 'Operational analytics'],
        ],
        'property' => [
            'name' => 'Property',
            'headline' => 'Modern property operations in one place',
            'description' => 'Run units, leases, invoicing, and collections through a unified management experience.',
            'points' => ['Lease lifecycle', 'Rent invoicing', 'Tenant records', 'Arrears tracking'],
        ],
        'pos' => [
            'name' => 'POS',
            'headline' => 'Create your retail POS account',
            'description' => 'Go live with products, pricing, checkout, and daily sales insights on a reliable cloud stack.',
            'points' => ['Quick setup', 'Catalog controls', 'Sales tracking', 'Role-based access'],
        ],
    ];

    $activeModule = $moduleMeta[$moduleKey] ?? null;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | {{ config('app.name', 'Tiwi') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --tiwi-bg: #f1f3f8;
            --tiwi-ink: #0f1828;
            --tiwi-body: #314056;
            --tiwi-muted: #5f6e82;
            --tiwi-border: #d9dee8;
            --tiwi-brand: #e30613;
            --tiwi-surface: #ffffff;
            --tiwi-danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            color: var(--tiwi-ink);
            background: linear-gradient(180deg, #f5f7fb 0%, #eef2f8 100%);
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
            gap: 12px;
            font-size: 16px;
        }

        .top-signin {
            color: var(--tiwi-brand);
            font-weight: 700;
        }

        .top-signup {
            color: var(--tiwi-brand);
            border: 1px solid var(--tiwi-brand);
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 700;
            transition: background .2s ease, color .2s ease;
        }

        .top-signup:hover {
            background: var(--tiwi-brand);
            color: #fff;
        }

        .hero {
            padding: 46px 0 58px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 470px;
            gap: 28px;
            align-items: start;
        }

        .content-panel,
        .form-panel {
            background: var(--tiwi-surface);
            border: 1px solid var(--tiwi-border);
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 18px 42px rgba(15, 27, 43, 0.07);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eef4ff;
            color: #1e4f9d;
            border-radius: 999px;
            padding: 7px 13px;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .title {
            margin: 16px 0 10px;
            font-size: clamp(2rem, 4.5vw, 3.2rem);
            line-height: 1.06;
            letter-spacing: -0.03em;
            color: #101a2a;
        }

        .description {
            margin: 0;
            color: var(--tiwi-body);
            font-size: 1.04rem;
            line-height: 1.65;
            max-width: 48ch;
        }

        .point-grid {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .point {
            border: 1px solid var(--tiwi-border);
            border-radius: 12px;
            background: #fafbff;
            padding: 12px 13px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #27374f;
        }

        .form-panel h2 {
            margin: 0;
            font-size: 1.65rem;
            line-height: 1.2;
            letter-spacing: -0.02em;
            color: #111d31;
        }

        .form-panel .sub {
            margin: 8px 0 0;
            color: #4a5a72;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .module-note {
            margin-top: 14px;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #d4def3;
            background: #f4f8ff;
            color: #1f4174;
            font-size: 0.88rem;
        }

        .error-summary {
            margin-top: 14px;
            padding: 11px 12px;
            border-radius: 10px;
            border: 1px solid #f2c9c5;
            background: #fff5f4;
            color: var(--tiwi-danger);
            font-size: 0.88rem;
            line-height: 1.45;
        }

        .error-summary ul {
            margin: 8px 0 0 18px;
            padding: 0;
        }

        .form-grid {
            margin-top: 18px;
            display: grid;
            gap: 14px;
        }

        .field label {
            display: inline-block;
            margin-bottom: 6px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #213149;
        }

        .field input {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #cad3e3;
            background: #fff;
            padding: 11px 12px;
            font: inherit;
            font-size: 0.94rem;
            color: #16233a;
            outline: none;
            transition: border-color .16s ease, box-shadow .16s ease;
        }

        .field input:focus {
            border-color: #7b91bf;
            box-shadow: 0 0 0 4px rgba(92, 122, 185, 0.14);
        }

        .field .error {
            margin-top: 5px;
            color: var(--tiwi-danger);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .cta-row {
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .signin-link {
            font-size: 0.9rem;
            color: #3f4d63;
            text-decoration: underline;
        }

        .signin-link:hover {
            color: #1d4e97;
        }

        .submit {
            border: 0;
            border-radius: 11px;
            padding: 12px 20px;
            font: inherit;
            font-size: 0.96rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #fff;
            background: linear-gradient(90deg, #0f1f36 0%, #1f344e 100%);
            cursor: pointer;
            transition: transform .16s ease, box-shadow .16s ease;
        }

        .submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(31, 52, 78, 0.28);
        }

        .form-note {
            margin-top: 11px;
            color: #55647b;
            font-size: 0.82rem;
            line-height: 1.5;
        }

        @media (max-width: 1060px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .main-nav {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .container {
                width: min(1200px, 94%);
            }

            .topbar-inner {
                min-height: 72px;
            }

            .brand-word {
                letter-spacing: .38em;
            }

            .top-signup {
                padding: 8px 12px;
            }

            .content-panel,
            .form-panel {
                padding: 20px;
                border-radius: 14px;
            }

            .point-grid {
                grid-template-columns: 1fr;
            }

            .cta-row {
                flex-direction: column;
                align-items: stretch;
            }

            .submit {
                width: 100%;
            }

            .signin-link {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-badge" aria-hidden="true">
                    <span class="shape s1"></span>
                    <span class="shape s2"></span>
                    <span class="shape s3"></span>
                    <span class="shape s4"></span>
                </span>
                <span class="brand-word">tiwi</span>
            </a>

            <nav class="main-nav" aria-label="Main">
                <a href="{{ route('home') }}#products">Products <span>v</span></a>
                <a href="{{ route('home') }}#customers">Customers <span>v</span></a>
                <a href="{{ route('home') }}#partners">Partners <span>v</span></a>
                <a href="{{ route('home') }}#resources">Resources <span>v</span></a>
            </nav>

            <div class="top-actions">
                <a class="top-signin" href="{{ route('login') }}">Sign in</a>
                <a class="top-signup" href="{{ route('pricing') }}">Pricing</a>
            </div>
        </div>
    </header>

    <main class="hero">
        <div class="container hero-grid">
            <section class="content-panel">
                <span class="eyebrow">{{ $activeModule['name'] ?? 'Unified SaaS Platform' }}</span>
                <h1 class="title">{{ $activeModule['headline'] ?? 'Create your TIWI account' }}</h1>
                <p class="description">
                    {{ $activeModule['description'] ?? 'Start your tenant in one secure platform and expand to School, Hospital, Property, and POS modules as your business grows.' }}
                </p>

                <div class="point-grid">
                    @foreach(($activeModule['points'] ?? ['Secure onboarding', 'Quick activation', 'Centralized billing', 'Cross-module growth']) as $point)
                        <div class="point">{{ $point }}</div>
                    @endforeach
                </div>
            </section>

            <section class="form-panel">
                <h2>Create Account</h2>
                <p class="sub">Complete your details to continue onboarding.</p>

                @if (!empty($moduleSelection))
                    <div class="module-note">
                        Registration for <strong>{{ $activeModule['name'] ?? ucfirst($moduleSelection) }}</strong> module.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-summary">
                        Please correct the highlighted fields before continuing.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="form-grid">
                    @csrf
                    @if(!empty($moduleSelection))
                        <input type="hidden" name="selected_module" value="{{ $moduleSelection }}">
                    @endif

                    <div class="field">
                        <label for="name">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name">
                        @error('name')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="email">Work Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@company.com">
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="At least 8 characters">
                        @error('password')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password">
                        @error('password_confirmation')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="cta-row">
                        <a class="signin-link" href="{{ route('login') }}">Already registered?</a>
                        <button class="submit" type="submit">Register</button>
                    </div>
                </form>

                <p class="form-note">By creating an account, you agree to TIWI onboarding and account setup communications.</p>
            </section>
        </div>
    </main>
</body>
</html>
