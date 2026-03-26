<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ── DESIGN TOKENS (mirrors dashboard) ── */
        :root {
            --card-bg:        rgba(255,255,255,0.72);
            --card-border:    rgba(255,255,255,0.55);
            --card-shadow:    0 8px 32px rgba(108,99,255,0.10);
            --card-backdrop:  blur(18px) saturate(1.6);
            --stat-gradient:  linear-gradient(135deg,#FF4C60,#6C63FF);
            --text-main:      #1a1a2e;
            --text-soft:      #888;
            --accent-pink:    #FF4C60;
            --accent-purple:  #6C63FF;
            --accent-teal:    #4ECDC4;
            --accent-yellow:  #FDCB6E;
            --page-bg:        #f0f0f8;
            --input-bg:       rgba(255,255,255,0.60);
            --input-border:   rgba(108,99,255,0.18);
            --input-focus:    rgba(108,99,255,0.45);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--page-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(108,99,255,0.10) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 90%, rgba(255,76,96,0.08) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 60% 40%, rgba(78,205,196,0.07) 0%, transparent 50%);
        }

        /* ── BACKGROUND BLOBS ── */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        .blob-1 { width: 400px; height: 400px; background: rgba(108,99,255,0.11); top: -100px; left: -100px; }
        .blob-2 { width: 300px; height: 300px; background: rgba(255,76,96,0.09);  bottom: -80px; right: -80px; }
        .blob-3 { width: 220px; height: 220px; background: rgba(78,205,196,0.08); top: 55%; left: 58%; }

        /* ── CARD ── */
        .card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            -webkit-backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            padding: 3rem 2.8rem 2.6rem;
            max-width: 460px;
            width: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
            animation: card-in 0.5s cubic-bezier(0.2,0.9,0.4,1) both;
        }

        /* light refraction — mirrors stat-card::before */
        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(600px circle at 80% 10%, rgba(255,255,255,0.18), transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* accent dot — matches stat-card::after */
        .card::after {
            content: '';
            position: absolute;
            top: 1.4rem; right: 1.8rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: var(--accent-purple);
            opacity: 0.55;
        }

        .card-inner { position: relative; z-index: 1; }

        @keyframes card-in {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── ICON BADGE ── */
        .icon-badge {
            width: 64px; height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #6C63FF 0%, #4ECDC4 100%);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.6rem;
            box-shadow: 0 8px 24px rgba(108,99,255,0.30);
            animation: badge-pop 0.45s 0.15s cubic-bezier(0.2,0.9,0.4,1) both;
        }
        .icon-badge i { font-size: 1.5rem; color: #fff; }

        @keyframes badge-pop {
            from { opacity: 0; transform: scale(0.7) rotate(-10deg); }
            to   { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        /* ── EYEBROW LABEL — matches .stat-label ── */
        .eyebrow {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 0.5rem;
        }

        /* ── HEADING — matches .stat-value gradient ── */
        h1 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.15;
            background: var(--stat-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            animation: value-in 0.4s 0.2s cubic-bezier(0.2,0.9,0.4,1) both;
        }

        .subtitle {
            font-size: 0.9rem;
            color: var(--text-soft);
            line-height: 1.6;
            margin-bottom: 2rem;
            animation: value-in 0.4s 0.28s cubic-bezier(0.2,0.9,0.4,1) both;
        }

        @keyframes value-in {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── FORM ── */
        .form-group {
            margin-bottom: 1.2rem;
            animation: value-in 0.4s cubic-bezier(0.2,0.9,0.4,1) both;
        }
        .form-group:nth-child(1) { animation-delay: 0.32s; }
        .form-group:nth-child(2) { animation-delay: 0.40s; }

        .form-label {
            display: block;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 0.55rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-soft);
            font-size: 0.9rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap .toggle-pass {
            position: absolute;
            right: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-soft);
            font-size: 0.9rem;
            cursor: pointer;
            pointer-events: all;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 14px;
            padding: 0.85rem 3rem 0.85rem 2.8rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.95rem;
            color: var(--text-main);
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
            backdrop-filter: blur(6px);
        }

        input[type="password"]::placeholder,
        input[type="text"]::placeholder { color: #bbb; }

        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.10);
            background: rgba(255,255,255,0.85);
        }

        .input-wrap:focus-within i.lead-icon { color: var(--accent-purple); }

        /* ── PASSWORD STRENGTH ── */
        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 0.5rem;
        }
        .strength-bar span {
            flex: 1;
            height: 3px;
            border-radius: 999px;
            background: rgba(108,99,255,0.10);
            transition: background 0.3s;
        }
        .strength-bar.s1 span:nth-child(1)                          { background: #FF4C60; }
        .strength-bar.s2 span:nth-child(-n+2)                       { background: #FDCB6E; }
        .strength-bar.s3 span:nth-child(-n+3)                       { background: #4ECDC4; }
        .strength-bar.s4 span                                        { background: #6C63FF; }
        .strength-label { font-size: 0.72rem; color: var(--text-soft); margin-top: 0.3rem; }

        /* ── SUBMIT BUTTON ── */
        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #FF4C60 0%, #6C63FF 100%);
            color: #fff;
            border: none;
            border-radius: 16px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(255,76,96,0.28);
            transition: transform 0.25s cubic-bezier(0.2,0.9,0.4,1),
                        box-shadow 0.25s cubic-bezier(0.2,0.9,0.4,1);
            margin-top: 0.5rem;
            animation: value-in 0.4s 0.48s cubic-bezier(0.2,0.9,0.4,1) both;
        }
        .btn-submit:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(255,76,96,0.36);
        }
        .btn-submit:active { transform: translateY(0) scale(0.99); }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(108,99,255,0.18), transparent);
            margin: 1.8rem 0 1.4rem;
        }

        /* ── FOOTER NOTE ── */
        .footer-note {
            font-size: 0.76rem;
            color: var(--text-soft);
            text-align: center;
            line-height: 1.6;
        }

        /* ── VALIDATION HINTS ── */
        .hint-list {
            list-style: none;
            margin-top: 0.55rem;
            display: flex;
            flex-direction: column;
            gap: 0.22rem;
        }
        .hint-list li {
            font-size: 0.73rem;
            color: #bbb;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.25s;
        }
        .hint-list li i { font-size: 0.65rem; }
        .hint-list li.ok { color: var(--accent-teal); }
        .hint-list li.ok i::before { content: '\f058'; font-family: 'Font Awesome 6 Free'; font-weight: 900; }
        .hint-list li:not(.ok) i::before { content: '\f111'; font-family: 'Font Awesome 6 Free'; font-weight: 400; }

        /* match-note */
        .match-note {
            font-size: 0.73rem;
            margin-top: 0.4rem;
            min-height: 1rem;
            transition: color 0.25s;
        }
        .match-note.ok    { color: var(--accent-teal); }
        .match-note.error { color: var(--accent-pink); }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="card">
        <div class="card-inner">

            <!-- icon badge -->
            <div class="icon-badge">
                <i class="fa-solid fa-key"></i>
            </div>

            <p class="eyebrow">Account Security</p>
            <h1>New Password</h1>
            <p class="subtitle">Choose a strong password to secure your account.</p>

            <form method="POST" action="{{ route('reset.password') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- new password -->
                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock lead-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Enter new password" autocomplete="new-password">
                        <button type="button" class="toggle-pass" onclick="toggleVis('password', this)" tabindex="-1">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <!-- strength bar -->
                    <div class="strength-bar" id="strengthBar">
                        <span></span><span></span><span></span><span></span>
                    </div>
                    <div class="strength-label" id="strengthLabel"></div>
                    <!-- hints -->
                    <ul class="hint-list" id="hintList">
                        <li id="h-len"><i></i>At least 8 characters</li>
                        <li id="h-up"><i></i>One uppercase letter</li>
                        <li id="h-num"><i></i>One number</li>
                        <li id="h-sym"><i></i>One special character</li>
                    </ul>
                </div>

                <!-- confirm password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock-open lead-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" autocomplete="new-password">
                        <button type="button" class="toggle-pass" onclick="toggleVis('password_confirmation', this)" tabindex="-1">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="match-note" id="matchNote"></div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-shield-halved" style="margin-right:0.5rem;"></i>Reset Password
                </button>
            </form>

            <div class="divider"></div>

            <p class="footer-note">
                <i class="fa-solid fa-circle-info" style="color:var(--accent-purple);margin-right:4px;"></i>
                Remember your password? <a href="{{ route('login') }}" style="color:var(--accent-purple);text-decoration:none;font-weight:600;">Sign in</a>
            </p>

        </div>
    </div>

    <script>
        /* ── TOGGLE PASSWORD VISIBILITY ── */
        function toggleVis(id, btn) {
            const inp = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inp.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        /* ── PASSWORD STRENGTH ── */
        const pwInput   = document.getElementById('password');
        const cfInput   = document.getElementById('password_confirmation');
        const bar       = document.getElementById('strengthBar');
        const lbl       = document.getElementById('strengthLabel');
        const matchNote = document.getElementById('matchNote');

        const hints = {
            'h-len': v => v.length >= 8,
            'h-up':  v => /[A-Z]/.test(v),
            'h-num': v => /[0-9]/.test(v),
            'h-sym': v => /[^A-Za-z0-9]/.test(v),
        };

        const strengthMeta = [
            { cls: '',   text: '' },
            { cls: 's1', text: 'Weak' },
            { cls: 's2', text: 'Fair' },
            { cls: 's3', text: 'Good' },
            { cls: 's4', text: 'Strong' },
        ];

        pwInput.addEventListener('input', () => {
            const v = pwInput.value;
            let score = 0;

            for (const [id, test] of Object.entries(hints)) {
                const li = document.getElementById(id);
                if (test(v)) { li.classList.add('ok'); score++; }
                else          { li.classList.remove('ok'); }
            }

            bar.className = 'strength-bar' + (v.length ? ` s${score}` : '');
            lbl.textContent = v.length ? strengthMeta[score].text : '';
            checkMatch();
        });

        cfInput.addEventListener('input', checkMatch);

        function checkMatch() {
            const p = pwInput.value, c = cfInput.value;
            if (!c) { matchNote.textContent = ''; matchNote.className = 'match-note'; return; }
            if (p === c) {
                matchNote.textContent = '✓ Passwords match';
                matchNote.className = 'match-note ok';
            } else {
                matchNote.textContent = '✗ Passwords do not match';
                matchNote.className = 'match-note error';
            }
        }

        /* ── MOUSE GLOW (matches dashboard stat-card) ── */
        const card = document.querySelector('.card');
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            card.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            card.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    </script>
</body>
</html>