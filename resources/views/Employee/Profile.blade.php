<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile</title>
    <x-link />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-gradient-start: #f0f3fa;
            --bg-gradient-end: #e9eef5;
            --card-bg: rgba(255, 255, 255, 0.75);
            --card-border: rgba(255, 255, 255, 0.5);
            --card-shadow: 0 25px 50px -18px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.7) inset;
            --text-primary: #1b1f2c;
            --text-secondary: #4d5466;
            --text-soft: #7b8395;
            --header-bg: rgba(255, 255, 255, 0.4);
            --menu-bg: rgba(255, 255, 255, 0.3);
            --toggle-bg: rgba(255, 255, 255, 0.4);
            --toggle-border: rgba(255, 255, 255, 0.6);
            --card-backdrop: blur(16px);
            --input-bg: rgba(255, 255, 255, 0.6);
            --input-border: rgba(200, 205, 220, 0.6);
            --input-focus: #6C63FF;
        }

        body.dark {
            --bg-gradient-start: #0c0c17;
            --bg-gradient-end: #151522;
            --card-bg: rgba(20, 20, 35, 0.6);
            --card-border: rgba(255, 255, 255, 0.03);
            --card-shadow: 0 30px 60px -20px #000000, 0 0 0 1px rgba(255, 255, 255, 0.02) inset;
            --text-primary: #f0f0fd;
            --text-secondary: #bcc1d4;
            --text-soft: #8f95aa;
            --header-bg: rgba(10, 10, 22, 0.5);
            --menu-bg: rgba(10, 10, 22, 0.5);
            --toggle-bg: rgba(30, 30, 50, 0.6);
            --toggle-border: rgba(255, 255, 255, 0.1);
            --card-backdrop: blur(20px);
            --input-bg: rgba(255, 255, 255, 0.04);
            --input-border: rgba(255, 255, 255, 0.08);
            --input-focus: #6C63FF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, var(--bg-gradient-start), var(--bg-gradient-end));
            min-height: 100vh;
            color: var(--text-primary);
            transition: background-color 0.4s cubic-bezier(0.2, 0.9, 0.3, 1), color 0.3s ease;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: var(--menu-bg);
            backdrop-filter: var(--card-backdrop);
            border-right: 1px solid var(--card-border);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.2rem;
            gap: 0.5rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        /* MAIN */
        .main { flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* HEADER */
        .header {
            position: sticky; top: 0; z-index: 100;
            background: var(--header-bg);
            backdrop-filter: var(--card-backdrop);
            border-bottom: 1px solid var(--card-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }
        .header-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.3rem; font-weight: 600;
            color: var(--text-primary);
        }
        .header-right { display: flex; align-items: center; gap: 1.2rem; }
        .theme-toggle {
            display: flex;
            background: var(--toggle-bg);
            border: 1px solid var(--toggle-border);
            border-radius: 60px;
            padding: 0.3rem; gap: 0.2rem;
        }
        .toggle-pill {
            padding: 0.4rem 1rem; border-radius: 50px;
            font-size: 0.82rem; font-weight: 600;
            cursor: pointer; border: none;
            background: transparent; color: var(--text-secondary);
            transition: all 0.25s ease;
        }
        .toggle-pill.active { background: #FF4C60; color: white; box-shadow: 0 6px 14px #FF4C6080; }

        /* CONTENT */
        .content { 
            padding: 2rem; 
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center; 
        }

        .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem; font-weight: 600;
            color: var(--text-primary); margin-bottom: 1.5rem;
            width: 100%;
            max-width: 760px;
        }

        /* PROFILE CARD */
        .profile-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            border-radius: 36px;
            padding: 2.5rem;
            width: 100%;
            max-width: 760px;
            align-self: center;
            position: relative; overflow: hidden;
        }
        .profile-card::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(800px circle at var(--x, 50%) var(--y, 0%), rgba(255,255,255,0.12), transparent 50%);
            opacity: 0; transition: opacity 0.3s ease;
            pointer-events: none; border-radius: inherit;
        }
        .profile-card:hover::before { opacity: 1; }

        /* AVATAR BANNER */
        .profile-header {
            display: flex; align-items: center; gap: 1.5rem;
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--card-border);
        }
        .avatar-ring {
            width: 72px; height: 72px; border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #6C63FF);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 1.5rem;
            font-family: 'Space Grotesk', sans-serif;
            flex-shrink: 0;
        }
        .avatar-info {}
        .avatar-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.25rem; font-weight: 700;
            color: var(--text-primary);
        }
        .avatar-sub {
            font-size: 0.85rem; color: var(--text-soft);
            margin-top: 0.2rem;
        }

        /* FORM GRID */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.4rem;
        }
        .form-group { display: flex; flex-direction: column; gap: 0.45rem; }
        .form-group.full { grid-column: 1 / -1; }

        .form-label {
            font-size: 0.78rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.06em;
            color: var(--text-soft);
        }

        .form-input, .form-textarea {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px;
            padding: 0.85rem 1.1rem;
            font-size: 0.95rem; font-weight: 500;
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            transition: all 0.25s ease;
            outline: none;
            width: 100%;
        }
        .form-input::placeholder, .form-textarea::placeholder { color: var(--text-soft); }
        .form-input:focus, .form-textarea:focus {
            border-color: #6C63FF;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15);
            background: var(--card-bg);
        }
        .form-textarea { resize: vertical; min-height: 110px; }

        /* SUBMIT */
        .btn-submit {
            margin-top: 0.5rem;
            border: none; border-radius: 50px;
            padding: 1rem 2.8rem;
            font-size: 1rem; font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: white; cursor: pointer;
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1);
            width: 100%;
        }
        .btn-submit:hover {
            transform: scale(1.04) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }
        .btn-submit:active { transform: scale(0.96) !important; }

        /* ERRORS */
        .error-list { margin-top: 1rem; display: flex; flex-direction: column; gap: 0.4rem; }
        .error-item {
            font-size: 0.85rem; color: #FF4C60;
            padding: 0.5rem 1rem;
            background: rgba(255, 76, 96, 0.08);
            border-radius: 10px;
            border: 1px solid rgba(255, 76, 96, 0.2);
        }

        @media (max-width: 700px) {
            .form-grid { grid-template-columns: 1fr; }
            .profile-card { padding: 1.5rem; border-radius: 24px; }
        }
    </style>
</head>

<body>

    <x-employee-menu />

    <div class="main">

        <header class="header">
            <div class="header-title">My Profile</div>
            <div class="header-right">
                <div class="theme-toggle">
                    <button class="toggle-pill active" id="lightBtn" onclick="setTheme('light')">☀️ Light</button>
                    <button class="toggle-pill" id="darkBtn" onclick="setTheme('dark')">🌙 Dark</button>
                </div>
            </div>
        </header>

        <div class="content">
            <p class="section-title">Edit Profile</p>

            <div class="profile-card" id="profileCard">

                <div class="profile-header">
                    <div class="avatar-ring" id="avatarInitials">--</div>
                    <div class="avatar-info">
                        <div class="avatar-name" id="headerName">{{ auth()->user()->name }}</div>
                        <div class="avatar-sub" id="headerEmail">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                {{-- Remove method="post" and action — JS handles submission --}}
                <form id="profileForm">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name</label>
                            <input class="form-input" type="text" name="name"
                                value="{{ auth()->user()->name }}" id="name" placeholder="Full Name">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input class="form-input" type="email" name="email"
                                value="{{ auth()->user()->email }}" id="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="post">Position / Post</label>
                            <input class="form-input" type="text" name="post"
                                value="{{ auth()->user()->post }}" id="post" placeholder="Job Title">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="mobile">Mobile Number</label>
                            <input class="form-input" type="number" name="mobile"
                                value="{{ auth()->user()->mobile }}" id="mobile"
                                placeholder="10-digit mobile" min="0">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="qualification">Qualification</label>
                            <input class="form-input" type="text" name="qualification"
                                value="{{ auth()->user()->qualification }}" id="qualification"
                                placeholder="Highest Qualification">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="experience">Experience (Years)</label>
                            <input class="form-input" type="number" name="experience"
                                value="{{ auth()->user()->experience }}" id="experience"
                                placeholder="Years of experience" min="0">
                        </div>

                        <div class="form-group full">
                            <label class="form-label" for="address">Address</label>
                            <textarea class="form-textarea" name="address" id="address"
                                placeholder="Full address">{{ auth()->user()->address }}</textarea>
                        </div>

                        <div class="form-group full">
                            <button type="submit" class="btn-submit" id="submitBtn">💾 Update Profile</button>
                        </div>
                    </div>

                    {{-- Error list rendered by JS --}}
                    <div class="error-list" id="errorList" style="display:none;"></div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // ── TOASTR CONFIG ──
        toastr.options = {
            positionClass: 'toast-bottom-right',
            closeButton: true,
            progressBar: true,
            timeOut: 3000
        };

        // ── THEME ──
        function setTheme(theme) {
            document.body.classList.toggle('dark', theme === 'dark');
            localStorage.setItem('theme', theme);
            document.getElementById('lightBtn').classList.toggle('active', theme === 'light');
            document.getElementById('darkBtn').classList.toggle('active', theme === 'dark');
        }
        (function initTheme() { setTheme(localStorage.getItem('theme') || 'light'); })();

        // ── AVATAR INITIALS ──
        const name = "{{ auth()->user()->name }}";
        const initials = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
        document.getElementById('avatarInitials').textContent = initials;

        // ── MOUSE GLOW ──
        const card = document.getElementById('profileCard');
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--x', ((e.clientX - rect.left) / rect.width * 100) + '%');
            card.style.setProperty('--y', ((e.clientY - rect.top) / rect.height * 100) + '%');
        });

        // ── PROFILE FORM SUBMISSION ──
        document.getElementById('profileForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const btn = document.getElementById('submitBtn');
            const errorList = document.getElementById('errorList');

            // Clear previous errors
            errorList.style.display = 'none';
            errorList.innerHTML = '';

            // Loading state
            btn.disabled = true;
            btn.textContent = '⏳ Updating...';

            try {
                const formData = new FormData(e.target);
                // Laravel requires _method spoofing for PUT via FormData
                formData.append('_method', 'PUT');

                const response = await fetch('/update_user', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success ?? 'Profile updated successfully!');

                    // Update the header name/email live without page reload
                    if (formData.get('name')) {
                        document.getElementById('headerName').textContent = formData.get('name');
                        const newInitials = formData.get('name').split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
                        document.getElementById('avatarInitials').textContent = newInitials;
                    }
                    if (formData.get('email')) {
                        document.getElementById('headerEmail').textContent = formData.get('email');
                    }

                } else if (response.status === 422) {
                    // Validation errors — render them styled
                    const errors = result.errors ?? {};
                    const messages = Object.values(errors).flat();

                    messages.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = 'error-item';
                        div.textContent = msg;
                        errorList.appendChild(div);
                    });

                    errorList.style.display = 'flex';
                    toastr.error('Please fix the errors below.');

                } else {
                    toastr.error(result.error ?? result.message ?? 'Something went wrong.');
                }

            } catch (err) {
                toastr.error('Update failed: ' + err.message);
                console.error(err);
            } finally {
                // Restore button
                btn.disabled = false;
                btn.textContent = '💾 Update Profile';
            }
        });
    </script>
</body>
</html>