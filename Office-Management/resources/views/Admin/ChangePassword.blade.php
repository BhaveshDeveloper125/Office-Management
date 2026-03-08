<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password • attnd.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-gradient-start: #f0f3fa;
            --bg-gradient-end:   #e9eef5;
            --card-bg:           rgba(255,255,255,0.75);
            --card-border:       rgba(255,255,255,0.5);
            --card-shadow:       0 25px 50px -18px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.7) inset;
            --text-primary:      #1b1f2c;
            --text-secondary:    #4d5466;
            --text-soft:         #7b8395;
            --header-bg:         rgba(255,255,255,0.4);
            --menu-bg:           rgba(255,255,255,0.3);
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
            --header-bg:         rgba(10,10,22,0.5);
            --menu-bg:           rgba(10,10,22,0.5);
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
            color: var(--text-primary);
            transition: background-color 0.4s cubic-bezier(0.2,0.9,0.3,1), color 0.3s ease;
            overflow-x: hidden;
        }

        .app { display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .menu-area {
            width: 280px; flex-shrink: 0;
            background: var(--menu-bg);
            backdrop-filter: var(--card-backdrop);
            border-right: 1px solid var(--card-border);
            box-shadow: 4px 0 30px -10px rgba(0,0,0,0.1);
            padding: 2rem 1rem;
            transition: background 0.4s, border-color 0.3s;
        }

        .logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem; font-weight: 600;
            letter-spacing: -0.02em;
            margin-bottom: 3rem; padding-left: 1rem;
            background: linear-gradient(130deg, #FF4C60, #6C63FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu-items { display: flex; flex-direction: column; gap: 0.8rem; }

        .menu-item {
            padding: 1rem 1.5rem; border-radius: 20px;
            font-weight: 500; color: var(--text-secondary);
            transition: all 0.25s ease; border: 1px solid transparent;
            cursor: pointer; text-decoration: none; display: block;
        }

        .menu-item:hover {
            background: var(--card-bg); border-color: var(--card-border);
            color: var(--text-primary); transform: translateX(6px);
        }

        .menu-item.active {
            background: var(--card-bg); border-color: #FF4C60;
            color: var(--text-primary); box-shadow: 0 6px 14px rgba(255,76,96,0.2);
        }

        /* ── MAIN ── */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

        /* ── HEADER ── */
        .header-area {
            padding: 1.5rem 2.5rem;
            background: var(--header-bg);
            backdrop-filter: var(--card-backdrop);
            border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center;
            justify-content: space-between;
            transition: background 0.4s;
            flex-wrap: wrap; gap: 1rem;
        }

        .header-left { display: flex; align-items: center; gap: 1rem; }

        .back-btn {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 0.5rem 1.1rem;
            font-size: 0.82rem; font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer; text-decoration: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(8px);
        }

        .back-btn:hover {
            border-color: #6C63FF; color: #6C63FF;
            transform: translateX(-3px);
        }

        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.6rem; font-weight: 600;
            letter-spacing: -0.02em;
        }

        .page-title span {
            background: linear-gradient(135deg, #FF4C60, #F91179);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .emp-pill {
            background: rgba(255,76,96,0.1);
            border: 1px solid rgba(255,76,96,0.22);
            border-radius: 20px; padding: 0.3rem 1rem;
            font-size: 0.82rem; font-weight: 600; color: #FF4C60;
        }

        .theme-toggle {
            background: var(--toggle-bg); backdrop-filter: blur(12px);
            border: 1px solid var(--toggle-border);
            border-radius: 60px; padding: 0.3rem;
            display: flex; gap: 0.3rem;
        }

        .theme-option {
            padding: 0.6rem 1.8rem; border-radius: 40px;
            font-size: 0.9rem; font-weight: 600; cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.3s ease; border: none; background: transparent;
        }

        .theme-option.active { background: #FF4C60; color: white; box-shadow: 0 6px 14px #FF4C6080; }

        /* ── CONTENT ── */
        .content {
            padding: 2.5rem;
            overflow-y: auto;
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        /* ── FORM CARD ── */
        .form-card {
            width: 100%;
            max-width: 520px;
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative; overflow: hidden;
        }

        .form-card::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.14), transparent 50%);
            opacity: 0; transition: opacity 0.5s;
            pointer-events: none; z-index: 0;
        }

        .form-card:hover::before { opacity: 1; }

        .form-card::after {
            content: ''; position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%; background: #FF4C60; opacity: 0.5; z-index: 1;
        }

        .form-inner { padding: 2.4rem 2.6rem; position: relative; z-index: 1; }

        /* ── CARD HEADER ── */
        .card-header { margin-bottom: 2rem; }

        .card-icon {
            font-size: 2.2rem; margin-bottom: 0.6rem;
            display: block;
        }

        .card-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.3rem; font-weight: 600;
            letter-spacing: -0.01em; color: var(--text-primary);
        }

        .card-subtitle {
            font-size: 0.82rem; color: var(--text-soft);
            margin-top: 0.3rem;
        }

        /* ── DIVIDER ── */
        .divider { height: 1px; background: var(--card-border); margin: 1.5rem 0; }

        /* ── EMAIL DISPLAY ── */
        .email-display {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px; padding: 0.78rem 1.1rem;
            font-size: 0.9rem; color: var(--text-soft);
            display: flex; align-items: center; gap: 0.6rem;
            margin-bottom: 1.3rem;
        }

        .email-display .lock-icon { font-size: 0.82rem; opacity: 0.6; }

        /* ── FIELDS ── */
        .field { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.1rem; }

        .field-label {
            font-size: 0.7rem; text-transform: uppercase;
            letter-spacing: 1.5px; font-weight: 600; color: var(--text-soft);
        }

        .field-wrap { position: relative; }

        .field-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px; padding: 0.85rem 3rem 0.85rem 1.2rem;
            font-family: 'Inter', sans-serif; font-size: 0.95rem;
            color: var(--text-primary); outline: none;
            transition: all 0.25s ease; backdrop-filter: blur(6px); width: 100%;
        }

        .field-input::placeholder { color: var(--text-soft); }

        .field-input:focus {
            border-color: rgba(255,76,96,0.45);
            box-shadow: 0 0 0 3px rgba(255,76,96,0.08);
        }

        /* show/hide password toggle */
        .eye-btn {
            position: absolute; right: 1rem; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; font-size: 1rem;
            color: var(--text-soft);
            transition: color 0.2s ease; padding: 0;
        }

        .eye-btn:hover { color: var(--text-primary); }

        /* ── STRENGTH METER ── */
        .strength-wrap { margin-top: 0.5rem; }

        .strength-bar {
            height: 4px; border-radius: 4px;
            background: var(--input-border);
            overflow: hidden; margin-bottom: 0.3rem;
        }

        .strength-fill {
            height: 100%; border-radius: 4px;
            transition: width 0.4s ease, background 0.4s ease;
            width: 0%;
        }

        .strength-text { font-size: 0.72rem; color: var(--text-soft); }

        /* ── MATCH HINT ── */
        .match-hint {
            font-size: 0.75rem; margin-top: 0.4rem;
            transition: color 0.3s ease;
            min-height: 1rem;
        }

        /* ── SUBMIT BTN ── */
        .btn-change {
            width: 100%; margin-top: 0.6rem;
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white; border: none; border-radius: 50px;
            padding: 1rem 2.8rem;
            font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s ease; letter-spacing: 0.3px;
        }

        .btn-change:hover {
            transform: scale(1.04) translateY(-3px); filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #FF4C6080;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .menu-area { width: 80px; }
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; }
            .form-inner { padding: 1.8rem 1.5rem; }
        }
    </style>
</head>

<body class="">
<div class="app">

    <x-side-bar-menu />

    <!-- ── MAIN ── -->
    <div class="main">

        <!-- header -->
        <div class="header-area">
            <div class="header-left">
                <a class="back-btn" href="#">← Back</a>
                <div class="page-title">Change <span>Password</span></div>
                <div class="emp-pill">{{ $user->email }}</div>
            </div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light">☀️ light</button>
                <button class="theme-option" data-theme="dark">🌙 dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <div class="form-card" id="formCard">
                <div class="form-inner">

                    <div class="card-header">
                        <span class="card-icon">🔑</span>
                        <div class="card-title">Set a new password</div>
                        <div class="card-subtitle">Password must be at least 8 characters long.</div>
                    </div>

                    <div class="divider"></div>

                    <form action="/change_password" method="post">
                        @csrf
                        @method('PUT')

                        <!-- locked email -->
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <div class="email-display">
                            <span class="lock-icon">🔒</span>
                            <span>{{ $user->email }}</span>
                        </div>

                        <!-- new password -->
                        <div class="field">
                            <label class="field-label" for="password">New Password</label>
                            <div class="field-wrap">
                                <input
                                    class="field-input"
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Enter new password"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" class="eye-btn" data-target="password">👁</button>
                            </div>
                            <div class="strength-wrap">
                                <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                                <div class="strength-text" id="strengthText">—</div>
                            </div>
                        </div>

                        <!-- confirm password -->
                        <div class="field">
                            <label class="field-label" for="password_confirmation">Confirm Password</label>
                            <div class="field-wrap">
                                <input
                                    class="field-input"
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Re-enter new password"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" class="eye-btn" data-target="password_confirmation">👁</button>
                            </div>
                            <div class="match-hint" id="matchHint"></div>
                        </div>

                        <button type="submit" class="btn-change" id="submitBtn">🔑 Update Password</button>

                    </form>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->
</div><!-- /app -->

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
        toastr.info(`✨ ${theme} mode`, '', { timeOut: 900 });
    }

    lightBtn.addEventListener('click', () => setTheme('light'));
    darkBtn.addEventListener('click',  () => setTheme('dark'));
    setTheme(localStorage.getItem('theme') || 'light');

    /* ── MOUSE GLOW ── */
    const card = document.getElementById('formCard');
    card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        card.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
        card.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
    });

    /* ── BUTTON CLICK FEEDBACK ── */
    document.getElementById('submitBtn').addEventListener('click', function () {
        this.style.transform = 'scale(0.96)';
        setTimeout(() => this.style.transform = '', 200);
    });

    /* ── SHOW / HIDE PASSWORD ── */
    document.querySelectorAll('.eye-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            input.type = input.type === 'password' ? 'text' : 'password';
            btn.textContent = input.type === 'password' ? '👁' : '🙈';
        });
    });

    /* ── PASSWORD STRENGTH ── */
    const pwInput      = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    pwInput.addEventListener('input', () => {
        const val = pwInput.value;
        let score = 0;
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { label: '—',       color: 'var(--input-border)', width: '0%'   },
            { label: 'Weak',    color: '#FF4C60',              width: '25%'  },
            { label: 'Fair',    color: '#FDCB6E',              width: '50%'  },
            { label: 'Good',    color: '#4ECDC4',              width: '75%'  },
            { label: 'Strong',  color: '#6C63FF',              width: '100%' },
        ];

        const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
        strengthFill.style.width      = lvl.width;
        strengthFill.style.background = lvl.color;
        strengthText.textContent      = val.length === 0 ? '—' : lvl.label;
        strengthText.style.color      = lvl.color;
    });

    /* ── PASSWORD MATCH ── */
    const confirmInput = document.getElementById('password_confirmation');
    const matchHint    = document.getElementById('matchHint');

    function checkMatch() {
        if (!confirmInput.value) { matchHint.textContent = ''; return; }
        const match = pwInput.value === confirmInput.value;
        matchHint.textContent = match ? '✓ Passwords match' : '✗ Passwords do not match';
        matchHint.style.color = match ? '#4ECDC4' : '#FF4C60';
    }

    pwInput.addEventListener('input',      checkMatch);
    confirmInput.addEventListener('input', checkMatch);
</script>
</body>
</html>