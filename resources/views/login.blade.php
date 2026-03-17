@php
    $appName = config('app.name', 'Application');
    $branding = config('domain-login.branding', []);
    $loginPoints = config('domain-login.login_points', []);
@endphp
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>{{ $appName }} | Logowanie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --card-bg: rgba(255, 255, 255, 0.94);
            --card-border: rgba(148, 163, 184, 0.18);
            --panel-bg: linear-gradient(160deg, #17324d 0%, #23486d 55%, #2b5d87 100%);
            --text-main: #142235;
            --text-muted: #5f6f82;
            --text-soft: #7c8c9d;
            --line: #d9e2ec;
            --field-bg: #f8fafc;
            --field-border: #d6e0ea;
            --focus-ring: rgba(37, 99, 235, 0.14);
            --primary: #1d4f91;
            --primary-strong: #163d72;
            --shadow: 0 28px 60px rgba(15, 23, 42, 0.12);
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Manrope", "Segoe UI", sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at 12% 16%, rgba(147, 197, 253, 0.38), transparent 24%),
                radial-gradient(circle at 88% 18%, rgba(191, 219, 254, 0.34), transparent 20%),
                radial-gradient(circle at 82% 82%, rgba(148, 163, 184, 0.18), transparent 24%),
                linear-gradient(180deg, #f4f7fb 0%, #e9eff5 54%, #e2eaf2 100%);
            position: relative;
            overflow: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            inset: auto;
            pointer-events: none;
            z-index: 0;
        }

        body::before {
            left: -8%;
            top: 10%;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.72) 0%, rgba(255, 255, 255, 0) 72%);
            filter: blur(8px);
        }

        body::after {
            right: -10%;
            bottom: -4%;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(203, 213, 225, 0.26) 0%, rgba(203, 213, 225, 0) 68%);
            filter: blur(10px);
        }

        .page-grid {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
        }

        .login-shell {
            width: min(100%, 980px);
            display: grid;
            grid-template-columns: minmax(300px, 1.03fr) minmax(320px, .97fr);
            border-radius: 30px;
            overflow: hidden;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
            position: relative;
        }

        .login-shell::before {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, 0.34);
            pointer-events: none;
            opacity: .8;
        }

        .brand-side {
            position: relative;
            padding: 2.4rem;
            color: #f8fbff;
            background: var(--panel-bg);
        }

        .brand-side::before {
            content: "";
            position: absolute;
            right: -60px;
            top: 24px;
            width: 180px;
            height: 180px;
            border-radius: 36px;
            transform: rotate(28deg);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-badge,
        .status-chip,
        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border-radius: 999px;
        }

        .brand-badge {
            position: relative;
            z-index: 1;
            padding: .55rem .85rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .brand-title {
            position: relative;
            z-index: 1;
            margin: 1.35rem 0 .75rem;
            font-size: clamp(2rem, 4.2vw, 3.05rem);
            line-height: 1.02;
            letter-spacing: -.05em;
            font-weight: 800;
        }

        .brand-copy {
            position: relative;
            z-index: 1;
            margin: 0;
            max-width: 36ch;
            color: rgba(248, 251, 255, 0.8);
            line-height: 1.8;
            font-size: .96rem;
        }

        .brand-points {
            position: relative;
            z-index: 1;
            display: grid;
            gap: .9rem;
            margin-top: 1.75rem;
        }

        .brand-point {
            display: flex;
            gap: .85rem;
            align-items: flex-start;
            padding: .95rem 1rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-point i {
            font-size: 1rem;
            color: #dbeafe;
            margin-top: .15rem;
        }

        .brand-point strong {
            display: block;
            font-size: .94rem;
            font-weight: 700;
        }

        .brand-point span {
            display: block;
            margin-top: .2rem;
            color: rgba(248, 251, 255, 0.74);
            font-size: .84rem;
            line-height: 1.6;
        }

        .brand-footer {
            position: relative;
            z-index: 1;
            margin-top: 2rem;
            color: rgba(248, 251, 255, 0.64);
            font-size: .82rem;
        }

        .form-side {
            padding: 2.3rem;
            background: linear-gradient(180deg, rgba(255,255,255,0.92) 0%, rgba(248,250,252,0.98) 100%);
        }

        .form-topline,
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: .8rem;
        }

        .form-topline {
            margin-bottom: 1.6rem;
        }

        .form-topline .system-name {
            font-size: .82rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--primary);
        }

        .status-chip,
        .footer-badge {
            padding: .45rem .75rem;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--text-muted);
            font-size: .78rem;
            font-weight: 600;
        }

        .form-title {
            margin: 0 0 .45rem;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -.04em;
        }

        .form-copy {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.75;
            font-size: .95rem;
        }

        .field-block + .field-block { margin-top: 1rem; }

        .field-label {
            display: block;
            margin-bottom: .55rem;
            font-size: .9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .input-shell {
            display: flex;
            align-items: center;
            min-height: 58px;
            border-radius: 18px;
            background: var(--field-bg);
            border: 1px solid var(--field-border);
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }

        .input-shell:focus-within {
            background: #fff;
            border-color: #afc4de;
            box-shadow: 0 0 0 4px var(--focus-ring);
        }

        .field-icon,
        .field-action {
            width: 54px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            color: #6b7c90;
        }

        .field-input {
            flex: 1 1 auto;
            min-width: 0;
            border: 0;
            outline: none;
            background: transparent;
            color: var(--text-main);
            font-size: .96rem;
            padding: 1rem 0;
        }

        .field-input::placeholder { color: #99a7b5; }

        .password-toggle {
            border: 0;
            background: transparent;
            color: #6b7c90;
            padding: 0;
            cursor: pointer;
        }

        .password-toggle:hover,
        .password-toggle:focus {
            color: var(--primary);
            outline: none;
        }

        .helper-text {
            margin-top: .5rem;
            color: var(--text-soft);
            font-size: .8rem;
            line-height: 1.55;
        }

        .submit-wrap { margin-top: 1.5rem; }

        .btn-login {
            width: 100%;
            min-height: 58px;
            border: 0;
            border-radius: 18px;
            color: #fff;
            font-size: .95rem;
            font-weight: 800;
            letter-spacing: .01em;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-strong) 100%);
            box-shadow: 0 16px 30px rgba(29, 79, 145, 0.2);
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }

        .btn-login:hover,
        .btn-login:focus {
            color: #fff;
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow: 0 18px 34px rgba(22, 61, 114, 0.22);
        }

        .form-footer {
            margin-top: 1rem;
            color: var(--text-soft);
            font-size: .8rem;
        }

        .toast-wrap {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 20;
        }

        .toast {
            border-radius: 16px;
            overflow: hidden;
        }

        @media (max-width: 900px) {
            .login-shell { grid-template-columns: 1fr; }
            .brand-side,
            .form-side { padding: 1.5rem; }
        }

        @media (max-width: 575.98px) {
            .page-grid { padding: .85rem; }
            .login-shell { border-radius: 22px; }
            .form-topline,
            .form-footer { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    @if(session('error'))
        <div class="toast-wrap">
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" data-bs-delay="12000" data-bs-autohide="true" id="ldapErrorToast">
                <div class="d-flex">
                    <div class="toast-body">{{ session('error') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Zamknij"></button>
                </div>
            </div>
        </div>
    @endif

    <main class="page-grid">
        <section class="login-shell">
            <aside class="brand-side">
                <div class="brand-badge">
                    <i class="bi bi-building-gear"></i>
                    {{ $branding['badge'] ?? 'Panel wewnetrzny' }}
                </div>

                <h1 class="brand-title">{{ $appName }}</h1>
                <p class="brand-copy">
                    {{ $branding['description'] ?? '' }}
                </p>

                <div class="brand-points">
                    @foreach($loginPoints as $point)
                        <div class="brand-point">
                            <i class="bi {{ $point['icon'] ?? 'bi-check-circle' }}"></i>
                            <div>
                                <strong>{{ $point['title'] ?? '' }}</strong>
                                <span>{{ $point['text'] ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="brand-footer">
                    {{ $appName }} • {{ $branding['footer_suffix'] ?? 'srodowisko wewnetrzne' }}
                </div>
            </aside>

            <div class="form-side">
                <div class="form-topline">
                    <div class="system-name">{{ $appName }}</div>
                    <div class="status-chip">
                        <i class="bi bi-shield-lock"></i>
                        {{ $branding['status_chip'] ?? 'Dostep chroniony' }}
                    </div>
                </div>

                <h2 class="form-title">Logowanie</h2>
                <p class="form-copy">{{ $branding['form_subtitle'] ?? '' }}</p>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="field-block">
                        <label for="username" class="field-label">Login</label>
                        <div class="input-shell">
                            <div class="field-icon"><i class="bi bi-person"></i></div>
                            <input
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                class="field-input"
                                placeholder="np. jnowak"
                                autocomplete="username"
                                required
                                autofocus
                            >
                        </div>
                        <div class="helper-text">Uzyj loginu przypisanego do Twojego konta domenowego.</div>
                    </div>

                    <div class="field-block">
                        <label for="password" class="field-label">Haslo</label>
                        <div class="input-shell">
                            <div class="field-icon"><i class="bi bi-key"></i></div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="field-input"
                                placeholder="Wpisz haslo"
                                autocomplete="current-password"
                                required
                            >
                            <div class="field-action">
                                <button type="button" class="password-toggle" id="togglePassword" aria-label="Pokaz lub ukryj haslo">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="helper-text">Po poprawnym logowaniu nastapi weryfikacja dostepu do panelu.</div>
                    </div>

                    <div class="submit-wrap">
                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Zaloguj sie
                        </button>
                    </div>
                </form>

                <div class="form-footer">
                    <span>W przypadku problemow z dostepem skontaktuj sie z administratorem.</span>
                    <span class="footer-badge">
                        <i class="bi bi-person-lock"></i>
                        Logowanie domenowe
                    </span>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toastEl = document.getElementById('ldapErrorToast');
        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (toastEl) {
            bootstrap.Toast.getOrCreateInstance(toastEl).show();
        }

        if (togglePasswordButton && passwordInput) {
            togglePasswordButton.addEventListener('click', () => {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                togglePasswordButton.innerHTML = isHidden
                    ? '<i class="bi bi-eye-slash"></i>'
                    : '<i class="bi bi-eye"></i>';
            });
        }
    </script>
</body>
</html>
