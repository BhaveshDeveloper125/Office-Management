<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employees • Add New</title>
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

        /* ── SHELL ── */
        .app { display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .menu-area {
            width: 280px;
            flex-shrink: 0;
            background: var(--menu-bg);
            backdrop-filter: var(--card-backdrop);
            border-right: 1px solid var(--card-border);
            box-shadow: 4px 0 30px -10px rgba(0,0,0,0.1);
            padding: 2rem 1rem;
            transition: background 0.4s, border-color 0.3s;
        }

        .logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            margin-bottom: 3rem;
            padding-left: 1rem;
            background: linear-gradient(130deg, #FF4C60, #6C63FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .menu-items { display: flex; flex-direction: column; gap: 0.8rem; }

        .menu-item {
            padding: 1rem 1.5rem;
            border-radius: 20px;
            font-weight: 500;
            color: var(--text-secondary);
            transition: all 0.25s ease;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .menu-item:hover {
            background: var(--card-bg);
            border-color: var(--card-border);
            color: var(--text-primary);
            transform: translateX(6px);
        }

        .menu-item.active {
            background: var(--card-bg);
            border-color: #FF4C60;
            color: var(--text-primary);
            box-shadow: 0 6px 14px rgba(255,76,96,0.2);
        }

        /* ── MAIN ── */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

        /* ── HEADER ── */
        .header-area {
            padding: 1.5rem 2.5rem;
            background: var(--header-bg);
            backdrop-filter: var(--card-backdrop);
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background 0.4s;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .page-title span {
            background: linear-gradient(135deg, #FF4C60, #F91179);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .theme-toggle {
            background: var(--toggle-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--toggle-border);
            border-radius: 60px;
            padding: 0.3rem;
            display: flex;
            gap: 0.3rem;
        }

        .theme-option {
            padding: 0.6rem 1.8rem;
            border-radius: 40px;
            font-size: 0.9rem;
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

        /* ── CONTENT ── */
        .content {
            padding: 2.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ── FORM CARD ── */
        .form-card {
            width: 100%;
            max-width: 860px;
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            padding: 2.8rem 3rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
        }

        /* light refraction */
        .form-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.13), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .form-card:hover::before { opacity: 1; }

        /* accent dot */
        .form-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #6C63FF;
            opacity: 0.5;
            z-index: 1;
        }

        .form-inner { position: relative; z-index: 1; }

        /* ── SECTION DIVIDERS ── */
        .form-section {
            margin-bottom: 2rem;
        }

        .form-section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .form-section-title::before {
            content: '';
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6C63FF, #4a43d9);
            flex-shrink: 0;
        }

        .form-section-title.red::before { background: linear-gradient(135deg, #FF4C60, #F91179); }
        .form-section-title.teal::before { background: linear-gradient(135deg, #4ECDC4, #2fb8af); }
        .form-section-title.gold::before { background: linear-gradient(135deg, #FDCB6E, #e0a940); }

        /* ── GRID ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-grid.three { grid-template-columns: 1fr 1fr 1fr; }
        .form-grid.single { grid-template-columns: 1fr; }
        .col-span-2 { grid-column: 1 / -1; }

        /* ── FIELD ── */
        .field { display: flex; flex-direction: column; gap: 0.4rem; }

        .field-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 600;
            color: var(--text-soft);
        }

        .field-input,
        .field-select,
        .field-textarea {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px;
            padding: 0.75rem 1.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.92rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(6px);
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
        }

        .field-input::placeholder,
        .field-textarea::placeholder { color: var(--text-soft); }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: rgba(108,99,255,0.45);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        .field-input::-webkit-calendar-picker-indicator,
        .field-input[type="time"]::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }

        .field-textarea {
            resize: vertical;
            min-height: 100px;
            border-radius: 20px;
        }

        /* custom select arrow */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '▾';
            position: absolute;
            right: 1.1rem; top: 50%;
            transform: translateY(-50%);
            color: var(--text-soft);
            pointer-events: none;
            font-size: 0.85rem;
        }

        /* ── DIVIDER LINE ── */
        .divider {
            border: none;
            border-top: 1px solid var(--card-border);
            margin: 1.8rem 0;
        }

        /* ── SUBMIT ROW ── */
        .submit-row {
            display: flex;
            justify-content: flex-end;
            padding-top: 0.5rem;
        }

        .submit-btn {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem 3.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.4px;
        }

        .submit-btn:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1000px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-grid.three { grid-template-columns: 1fr 1fr; }
            .col-span-2 { grid-column: auto; }
        }

        @media (max-width: 900px) {
            .menu-area { width: 80px; }
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
            .form-card { padding: 2rem 1.5rem; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; }
            .form-grid.three { grid-template-columns: 1fr; }
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
            <div class="page-title">👤 Add <span>New Employee</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light">☀️ light</button>
                <button class="theme-option" data-theme="dark">🌙 dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">
            <div class="form-card" id="formCard">
                <div class="form-inner">
                    <form id="AddEmployeeForm">

                        <!-- ── PERSONAL INFO ── -->
                        <div class="form-section">
                            <div class="form-section-title">Personal Information</div>
                            <div class="form-grid">

                                <div class="field">
                                    <label class="field-label" for="name">Full Name</label>
                                    <input class="field-input" type="text" name="name" id="name" placeholder="e.g. Jane Smith" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="email">Email Address</label>
                                    <input class="field-input" type="email" name="email" id="email" placeholder="jane@company.com" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="mobile">Mobile Number</label>
                                    <input class="field-input" type="number" name="mobile" id="mobile" placeholder="10-digit number" min="0" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="post">Post / Job Title</label>
                                    <input class="field-input" type="text" name="post" id="post" placeholder="e.g. Software Engineer" required>
                                </div>

                                <div class="field col-span-2">
                                    <label class="field-label" for="address">Address</label>
                                    <textarea class="field-textarea" name="address" id="address" placeholder="Full residential address…" required></textarea>
                                </div>

                            </div>
                        </div>

                        <hr class="divider">

                        <!-- ── PROFESSIONAL INFO ── -->
                        <div class="form-section">
                            <div class="form-section-title teal">Professional Details</div>
                            <div class="form-grid three">

                                <div class="field">
                                    <label class="field-label" for="qualification">Qualification</label>
                                    <input class="field-input" type="text" name="qualification" id="qualification" placeholder="e.g. B.Tech, MBA" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="experience">Experience (Years)</label>
                                    <input class="field-input" type="number" name="experience" id="experience" placeholder="0" min="0" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="joining">Joining Date</label>
                                    <input class="field-input" type="date" name="joining" id="joining" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="role_container">Role</label>
                                    <div class="select-wrap">
                                        <select class="field-select" name="role" id="role_container" required>
                                            <option disabled selected>Select Role</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="hours">Expected Working Hours</label>
                                    <input class="field-input" type="number" name="hours" id="hours" placeholder="e.g. 8" min="1" required>
                                </div>

                            </div>
                        </div>

                        <hr class="divider">

                        <!-- ── WORKING TIME ── -->
                        <div class="form-section">
                            <div class="form-section-title gold">Working Schedule</div>
                            <div class="form-grid">

                                <div class="field">
                                    <label class="field-label" for="working_from">Shift Starts</label>
                                    <input class="field-input" type="time" name="working_from" id="working_from" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="working_to">Shift Ends</label>
                                    <input class="field-input" type="time" name="working_to" id="working_to" required>
                                </div>

                            </div>
                        </div>

                        <hr class="divider">

                        <!-- ── CREDENTIALS ── -->
                        <div class="form-section">
                            <div class="form-section-title red">Account Credentials</div>
                            <div class="form-grid">

                                <div class="field">
                                    <label class="field-label" for="password">Password</label>
                                    <input class="field-input" type="password" name="password" id="password" placeholder="Set a strong password" required>
                                </div>

                                <div class="field">
                                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                                    <input class="field-input" type="password" name="password_confirmation" id="password_confirmation" placeholder="Repeat password" required>
                                </div>

                            </div>
                        </div>

                        <!-- ── SUBMIT ── -->
                        <div class="submit-row">
                            <button type="submit" class="submit-btn" id="submitBtn">✨ Add Employee</button>
                        </div>

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
    const formCard = document.getElementById('formCard');
    formCard.addEventListener('mousemove', e => {
        const r = formCard.getBoundingClientRect();
        formCard.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
        formCard.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
    });

    /* ── SUBMIT BUTTON FEEDBACK ── */
    document.getElementById('submitBtn').addEventListener('click', function () {
        this.style.transform = 'scale(0.96)';
        setTimeout(() => this.style.transform = '', 200);
    });

    /* ── ADD EMPLOYEE ── */
    async function AddEmployee(e) {
        e.preventDefault();
        const form = document.getElementById('AddEmployeeForm');
        const formData = new FormData(form);
        const csrfToken = document.querySelector('input[name="_token"]')?.value
            || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        try {
            const response = await fetch('/registration', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                toastr.error(result.error || 'Failed to add employee');
                return;
            }

            toastr.success(result.success || '✅ Employee added successfully!');
            form.reset();

        } catch (err) {
            toastr.error(String(err));
        }
    }

    document.getElementById('AddEmployeeForm').addEventListener('submit', AddEmployee);

    /* ── FETCH ROLES ── */
    async function GetRoles() {
        try {
            const response = await fetch('/roles');
            const result   = await response.json();

            if (!response.ok) { toastr.error(result.error); return; }

            const select = document.getElementById('role_container');
            result.roles.forEach(i => {
                const opt = document.createElement('option');
                opt.value       = i.name;
                opt.textContent = i.name;
                select.appendChild(opt);
            });
        } catch (err) {
            toastr.error('Failed to fetch roles: ' + err);
        }
    }

    document.addEventListener('DOMContentLoaded', GetRoles);
</script>
</body>
</html>