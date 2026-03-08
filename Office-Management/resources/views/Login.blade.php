<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        /* ── TOKENS ── */
        :root {
            --bg-gradient-start: #f0f3fa;
            --bg-gradient-end:   #e9eef5;
            --card-bg:           rgba(255,255,255,0.75);
            --card-border:       rgba(255,255,255,0.5);
            --card-shadow:       0 25px 50px -18px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.7) inset;
            --text-primary:      #1b1f2c;
            --text-secondary:    #4d5466;
            --text-soft:         #7b8395;
            --toggle-bg:         rgba(255,255,255,0.4);
            --toggle-border:     rgba(255,255,255,0.6);
            --card-backdrop:     blur(16px);
            --input-bg:          rgba(255,255,255,0.65);
            --input-border:      rgba(200,205,220,0.7);
        }

        body.dark {
            --bg-gradient-start: #0c0c17;
            --bg-gradient-end:   #151522;
            --card-bg:           rgba(20,20,35,0.6);
            --card-border:       rgba(255,255,255,0.03);
            --card-shadow:       0 30px 60px -20px #000, 0 0 0 1px rgba(255,255,255,0.02) inset;
            --text-primary:      #f0f0fd;
            --text-secondary:    #bcc1d4;
            --text-soft:         #8f95aa;
            --toggle-bg:         rgba(30,30,50,0.6);
            --toggle-border:     rgba(255,255,255,0.1);
            --card-backdrop:     blur(20px);
            --input-bg:          rgba(20,20,40,0.7);
            --input-border:      rgba(255,255,255,0.07);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, var(--bg-gradient-start), var(--bg-gradient-end));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            transition: background-color 0.4s cubic-bezier(0.2,0.9,0.3,1), color 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        /* ── BACKGROUND ORBS ── */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.18;
            pointer-events: none;
            z-index: 0;
            transition: opacity 0.4s ease;
        }

        body::before {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #6C63FF, transparent 70%);
            top: -150px; left: -150px;
        }

        body::after {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #FF4C60, transparent 70%);
            bottom: -120px; right: -120px;
        }

        body.dark::before, body.dark::after { opacity: 0.12; }

        /* ── THEME TOGGLE (top-right) ── */
        .theme-toggle {
            position: fixed;
            top: 1.5rem; right: 1.5rem;
            background: var(--toggle-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--toggle-border);
            border-radius: 60px;
            padding: 0.3rem;
            display: flex;
            gap: 0.3rem;
            z-index: 100;
        }

        .theme-option {
            padding: 0.5rem 1.4rem;
            border-radius: 40px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            border: none;
            background: transparent;
        }

        .theme-option.active {
            background: #FF4C60;
            color: white;
            box-shadow: 0 6px 14px #FF4C6080;
        }

        /* ── LOGIN CARD ── */
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            margin: 1.5rem;
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            padding: 3rem 2.8rem;
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,30%), rgba(255,255,255,0.14), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .login-card:hover::before { opacity: 1; }

        /* accent dot */
        .login-card::after {
            content: '';
            position: absolute;
            top: 1.4rem; right: 1.6rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #FF4C60;
            opacity: 0.5;
            z-index: 1;
        }

        .card-inner { position: relative; z-index: 1; }

        /* ── LOGO ── */
        .brand {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .brand-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.4rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            background: linear-gradient(130deg, #FF4C60, #6C63FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .brand-tagline {
            font-size: 0.82rem;
            color: var(--text-soft);
            margin-top: 0.25rem;
            letter-spacing: 0.5px;
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: var(--card-border);
            margin: 1.8rem 0;
        }

        /* ── FORM TITLE ── */
        .form-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.8rem;
            letter-spacing: -0.01em;
        }

        .form-title span {
            background: linear-gradient(135deg, #6C63FF, #4a43d9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ── FIELDS ── */
        .field { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.2rem; }

        .field-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: var(--text-soft);
        }

        .field-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px;
            padding: 0.85rem 1.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(6px);
            width: 100%;
        }

        .field-input::placeholder { color: var(--text-soft); }

        .field-input:focus {
            border-color: rgba(108,99,255,0.45);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        /* ── SUBMIT BTN ── */
        .login-btn {
            width: 100%;
            margin-top: 0.8rem;
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem 2.8rem;
            font-family: 'Inter', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .login-btn:hover {
            transform: scale(1.04) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        /* ── GLOW PULSE on logo ── */
        @keyframes soft-pulse {
            0%   { box-shadow: 0 0 10px rgba(255,76,96,0.1), 0 0 20px rgba(108,99,255,0.1); }
            100% { box-shadow: 0 0 25px rgba(255,76,96,0.3), 0 0 40px rgba(108,99,255,0.2); }
        }

        .glow-pulse { animation: soft-pulse 3s infinite alternate; }

        /* ── ERROR MESSAGES ── */
        .errors {
            margin-top: 1.2rem;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .error-item {
            font-size: 0.8rem;
            color: #FF4C60;
            background: rgba(255,76,96,0.08);
            border: 1px solid rgba(255,76,96,0.2);
            border-radius: 12px;
            padding: 0.5rem 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-item::before { content: '⚠'; font-size: 0.75rem; }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .login-card { padding: 2.2rem 1.8rem; }
            .brand-logo { font-size: 2rem; }
        }
    </style>
</head>

<body class="">

    <!-- theme toggle -->
    <div class="theme-toggle">
        <button class="theme-option active" data-theme="light">☀️ light</button>
        <button class="theme-option" data-theme="dark">🌙 dark</button>
    </div>

    <!-- login card -->
    <div class="login-card glow-pulse" id="loginCard">
        <div class="card-inner">

            <!-- brand -->
            <div class="brand">
                <div class="brand-logo">Company Name.</div>
                <div class="brand-tagline">Employee Attendance Management</div>
            </div>

            <div class="divider"></div>

            <div class="form-title">Welcome back — <span>Sign in</span></div>

            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="field">
                    <label class="field-label" for="email">Email Address</label>
                    <input
                        class="field-input"
                        type="email"
                        name="email"
                        id="email"
                        placeholder="you@company.com"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <input
                        class="field-input"
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••••"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="login-btn" id="loginBtn">→ Sign In</button>

                @if ($errors->any())
                    <div class="errors">
                        @foreach ($errors->all() as $error)
                            <div class="error-item">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        /* ── TOASTR ── */
        toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-bottom-right' };

        /* ── THEME ── */
        const lightBtn = document.querySelector('[data-theme="light"]');
        const darkBtn  = document.querySelector('[data-theme="dark"]');

        function setTheme(theme) {
            document.body.classList.toggle('dark', theme === 'dark');
            lightBtn.classList.toggle('active', theme === 'light');
            darkBtn.classList.toggle('active',  theme === 'dark');
            localStorage.setItem('theme', theme);
        }

        lightBtn.addEventListener('click', () => setTheme('light'));
        darkBtn.addEventListener('click',  () => setTheme('dark'));
        setTheme(localStorage.getItem('theme') || 'light');

        /* ── MOUSE GLOW ── */
        const card = document.getElementById('loginCard');
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            card.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            card.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });

        /* ── BUTTON CLICK FEEDBACK ── */
        const loginBtn = document.getElementById('loginBtn');
        loginBtn.addEventListener('click', function () {
            this.style.transform = 'scale(0.96)';
            setTimeout(() => this.style.transform = '', 200);
        });

        /* ── SHOW VALIDATION ERRORS AS TOASTS ── */
        document.querySelectorAll('.error-item').forEach(el => {
            toastr.error(el.textContent.trim());
        });
    </script>
</body>

</html>