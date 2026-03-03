<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiwi {{ $page['title'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --tiwi-bg: #eef2f7;
            --tiwi-ink: #121b2c;
            --tiwi-body: #3d4a5f;
            --tiwi-border: #d8dfea;
            --tiwi-primary: #7a4f6e;
            --tiwi-primary-strong: #673f5d;
            --tiwi-success: #0e9f6e;
            --tiwi-surface: #ffffff;
            --tiwi-soft: #f7f8fc;
            --tiwi-danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background: linear-gradient(180deg, #f4f6fb 0%, #edf1f8 100%);
            color: var(--tiwi-ink);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1180px, 92%);
            margin-inline: auto;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--tiwi-border);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-inner {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .brand {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--tiwi-primary);
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 24px;
            color: #2f3b4f;
            font-size: 0.98rem;
            font-weight: 700;
        }

        .main-nav span {
            color: #5d6b80;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.92rem;
            font-weight: 800;
            border: 1px solid transparent;
            transition: all .2s ease;
        }

        .btn-outline {
            border-color: var(--tiwi-border);
            color: #283447;
            background: #fff;
        }

        .btn-outline:hover {
            border-color: #b8c2d5;
            background: #f8f9fd;
        }

        .btn-primary {
            background: var(--tiwi-primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--tiwi-primary-strong);
        }

        .hero {
            padding: 40px 0 28px;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 450px;
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
            margin: 15px 0 10px;
            font-size: clamp(2rem, 5.2vw, 3.7rem);
            line-height: 1.04;
            letter-spacing: -0.03em;
            color: #111a2b;
        }

        .description {
            margin: 0;
            color: var(--tiwi-body);
            font-size: clamp(1rem, 1.5vw, 1.18rem);
            line-height: 1.65;
            max-width: 48ch;
        }

        .point-grid {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .point {
            border: 1px solid var(--tiwi-border);
            border-radius: 12px;
            background: #fafbff;
            padding: 12px 13px;
            font-size: 0.92rem;
            font-weight: 700;
            color: #2a3750;
        }

        .point strong {
            display: block;
            font-size: 1.02rem;
            color: #19263d;
        }

        .url-card {
            margin-top: 24px;
            border: 1px dashed #c1cbdd;
            border-radius: 12px;
            padding: 13px 14px;
            background: #fbfcff;
        }

        .url-card h3 {
            margin: 0;
            font-size: 0.93rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #4d5d75;
        }

        .url-item {
            margin-top: 10px;
            font-size: 0.92rem;
            color: #40506a;
            line-height: 1.5;
            word-break: break-word;
        }

        .url-item code {
            background: #edf3ff;
            border-radius: 6px;
            padding: 3px 8px;
            color: #1a3a72;
            font-size: 0.86rem;
        }

        .form-panel h2 {
            margin: 0;
            font-size: 1.6rem;
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

        .field input,
        .field select {
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

        .field input:focus,
        .field select:focus {
            border-color: #7b91bf;
            box-shadow: 0 0 0 4px rgba(92, 122, 185, 0.14);
        }

        .field .error {
            margin-top: 5px;
            color: var(--tiwi-danger);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .split {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .consent {
            margin-top: 2px;
            display: flex;
            gap: 8px;
            color: #4a5870;
            font-size: 0.82rem;
            line-height: 1.45;
        }

        .consent input {
            margin-top: 2px;
            accent-color: var(--tiwi-success);
        }

        .submit {
            margin-top: 6px;
            width: 100%;
            border: 0;
            border-radius: 11px;
            padding: 12px 14px;
            font: inherit;
            font-size: 0.96rem;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(90deg, #6d4563 0%, #8d5e81 100%);
            cursor: pointer;
            transition: transform .16s ease, box-shadow .16s ease;
        }

        .submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(111, 72, 102, 0.25);
        }

        .form-note {
            margin-top: 11px;
            color: #55647b;
            font-size: 0.82rem;
            line-height: 1.5;
        }

        .signin-link {
            margin-top: 12px;
            font-size: 0.88rem;
            color: #3f4d63;
        }

        .signin-link a {
            color: #1d4e97;
            font-weight: 700;
        }

        .cta-stack {
            margin-top: 20px;
            display: grid;
            gap: 10px;
        }

        .cta-item {
            border: 1px solid var(--tiwi-border);
            border-radius: 12px;
            padding: 13px;
            background: #f8fafe;
        }

        .cta-item strong {
            display: block;
            font-size: 0.95rem;
            color: #18263d;
        }

        .cta-item span {
            display: block;
            margin-top: 4px;
            color: #4d5d75;
            font-size: 0.85rem;
            line-height: 1.45;
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
                width: min(1180px, 94%);
            }

            .topbar-inner {
                min-height: 72px;
            }

            .brand {
                font-size: 1.78rem;
            }

            .actions .btn {
                padding: 9px 12px;
                font-size: 0.85rem;
            }

            .content-panel,
            .form-panel {
                padding: 20px;
                border-radius: 14px;
            }

            .point-grid,
            .split {
                grid-template-columns: 1fr;
            }

            .title {
                margin-top: 12px;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    @php($isSchool = $page['module'] === 'school')
    <header class="topbar">
        <div class="container">
            <div class="topbar-inner">
                <a href="{{ route('home') }}" class="brand">tiwi</a>
                <nav class="main-nav">
                    <span>{{ $page['title'] }}</span>
                    @foreach($page['menu'] as $item)
                        <a href="#">{{ $item }}</a>
                    @endforeach
                </nav>
                <div class="actions">
                    <a href="{{ route('login') }}" class="btn btn-outline">Sign in</a>
                    <a href="{{ route('register', ['module' => $page['module']]) }}" class="btn btn-primary">Try it free</a>
                </div>
            </div>
        </div>
    </header>

    <main class="hero">
        <div class="container hero-grid">
            <section class="content-panel">
                <span class="eyebrow">Tiwi {{ $page['title'] }}</span>
                <h1 class="title">{{ $page['hero'] }}</h1>
                <p class="description">{{ $page['description'] }}</p>

                <div class="point-grid">
                    @foreach($page['menu'] as $item)
                        <article class="point">
                            <strong>{{ $item }}</strong>
                            <span>Built into one secure tenant dashboard.</span>
                        </article>
                    @endforeach
                </div>

                <div class="url-card">
                    <h3>App URL flow</h3>
                    <p class="url-item">Marketing URL: <code>{{ url('/app/'.$landingSlug) }}</code></p>
                    <p class="url-item">Module URL after onboarding: <code>{{ url('/app/'.$page['module']) }}</code></p>
                </div>
            </section>

            @if($isSchool)
                <section class="form-panel">
                    <h2>Register Your School Account</h2>
                    <p class="sub">Create your admin account to start admissions, class setup, and fee invoicing in minutes.</p>

                    @if ($errors->any())
                        <div class="error-summary">
                            Please correct the highlighted fields before continuing.
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="form-grid">
                        @csrf
                        <input type="hidden" name="selected_module" value="school">

                        <div class="field">
                            <label for="school_name">School Name</label>
                            <input id="school_name" type="text" name="school_name" value="{{ old('school_name') }}" placeholder="Example Academy" autocomplete="organization">
                        </div>

                        <div class="split">
                            <div class="field">
                                <label for="name">Admin Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Your name">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label for="phone">Phone Number</label>
                                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+254 700 000 000" autocomplete="tel">
                            </div>
                        </div>

                        <div class="field">
                            <label for="email">Work Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="admin@school.com">
                            @error('email')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="split">
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
                        </div>

                        <label class="consent">
                            <input type="checkbox" name="accept_terms" required>
                            <span>I agree to Tiwi terms, data policy, and onboarding emails related to my school setup.</span>
                        </label>

                        <button class="submit" type="submit">Start School Free Trial</button>
                    </form>

                    <p class="form-note">After registration, your School module remains pre-selected in onboarding.</p>
                    <p class="signin-link">Already registered? <a href="{{ route('login') }}">Sign in to continue</a></p>
                </section>
            @else
                <section class="form-panel">
                    <h2>Get Started With {{ $page['title'] }}</h2>
                    <p class="sub">Start your free trial and continue onboarding with this app pre-selected for your tenant.</p>

                    <div class="cta-stack">
                        <div class="cta-item">
                            <strong>Fast setup</strong>
                            <span>Create your account and launch this module in under 5 minutes.</span>
                        </div>
                        <div class="cta-item">
                            <strong>Shared admin control</strong>
                            <span>Manage users, roles, and billing from one dashboard across all four modules.</span>
                        </div>
                        <div class="cta-item">
                            <strong>Tenant-secure data</strong>
                            <span>Records stay tenant-isolated with app-level access controls and subscription enforcement.</span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <a href="{{ route('register', ['module' => $page['module']]) }}" class="btn btn-primary" style="width:100%; justify-content:center;">Start now - It's free</a>
                        <a href="{{ route('pricing') }}" class="btn btn-outline" style="width:100%; justify-content:center;">Meet an advisor</a>
                    </div>

                    <p class="signin-link">Already registered? <a href="{{ route('login') }}">Sign in to continue</a></p>
                </section>
            @endif
        </div>
    </main>
</body>
</html>
