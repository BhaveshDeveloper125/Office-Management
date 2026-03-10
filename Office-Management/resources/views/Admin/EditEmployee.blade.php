<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <x-link />

    <style>
        /* ── CONTENT ── */
        .content { padding: 2.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 2rem; }

        /* ── GLASS CARD ── */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative; overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.13), transparent 50%);
            opacity: 0; transition: opacity 0.5s;
            pointer-events: none; z-index: 0;
        }

        .glass-card:hover::before { opacity: 1; }

        .glass-card::after {
            content: ''; position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%; opacity: 0.5; z-index: 1;
        }

        .card-dot-purple::after { background: #6C63FF; }
        .card-dot-teal::after   { background: #4ECDC4; }
        .card-dot-gold::after   { background: #FDCB6E; }
        .card-dot-red::after    { background: #FF4C60; }

        /* ── FORM INNER ── */
        .form-inner { padding: 2rem 2.4rem; position: relative; z-index: 1; }

        .section-label {
            font-size: 0.68rem; text-transform: uppercase;
            letter-spacing: 2px; font-weight: 600; color: var(--text-soft);
            margin-bottom: 1.4rem;
            display: flex; align-items: center; gap: 0.5rem;
        }

        .section-label::before {
            content: ''; display: inline-block;
            width: 8px; height: 8px; border-radius: 50%;
        }

        .lbl-purple::before { background: linear-gradient(135deg, #6C63FF, #4a43d9); }
        .lbl-teal::before   { background: linear-gradient(135deg, #4ECDC4, #2fb8af); }
        .lbl-gold::before   { background: linear-gradient(135deg, #FDCB6E, #e0a940); }
        .lbl-red::before    { background: linear-gradient(135deg, #FF4C60, #d43f52); }

        /* ── GRID ── */
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem 1.4rem; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem 1.4rem; }
        .col-span-2  { grid-column: span 2; }
        .col-span-3  { grid-column: span 3; }

        @media (max-width: 900px) {
            .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
            .col-span-2, .col-span-3   { grid-column: span 1; }
        }

        /* ── FIELD ── */
        .field { display: flex; flex-direction: column; gap: 0.4rem; }

        .field-label {
            font-size: 0.7rem; text-transform: uppercase;
            letter-spacing: 1.3px; font-weight: 600; color: var(--text-soft);
        }

        .field-input, .field-select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px; padding: 0.78rem 1.1rem;
            font-family: 'Inter', sans-serif; font-size: 0.93rem;
            color: var(--text-primary); outline: none;
            transition: all 0.25s ease; backdrop-filter: blur(6px); width: 100%;
            appearance: none; -webkit-appearance: none;
        }

        .field-input::placeholder { color: var(--text-soft); }

        .field-input:focus, .field-select:focus {
            border-color: rgba(108,99,255,0.45);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        .field-input::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }

        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '▾'; position: absolute;
            right: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--text-soft); pointer-events: none; font-size: 0.85rem;
        }

        /* ── CARD DIVIDER ── */
        .card-divider {
            height: 1px; background: var(--card-border);
            margin: 0 2.4rem;
        }

        /* ── TOGGLE ROW (working status) ── */
        .toggle-row {
            display: flex; align-items: center; gap: 1rem;
            padding: 1rem 0;
        }

        .toggle-label-text {
            font-size: 0.9rem; font-weight: 500;
            color: var(--text-secondary);
        }

        /* custom toggle */
        .toggle-wrap { position: relative; display: inline-flex; align-items: center; }

        .toggle-wrap input[type="checkbox"] { display: none; }

        .toggle-track {
            width: 52px; height: 28px;
            background: var(--input-border);
            border-radius: 50px; cursor: pointer;
            transition: background 0.3s ease;
            position: relative; display: block;
        }

        .toggle-track::after {
            content: '';
            position: absolute; top: 3px; left: 3px;
            width: 22px; height: 22px;
            background: white; border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        .toggle-wrap input:checked + .toggle-track {
            background: linear-gradient(145deg, #4ECDC4, #2fb8af);
        }

        .toggle-wrap input:checked + .toggle-track::after {
            transform: translateX(24px);
        }

        .status-pill {
            font-size: 0.75rem; font-weight: 600;
            border-radius: 20px; padding: 0.2rem 0.75rem;
            transition: all 0.3s ease;
        }

        .status-active   { background: rgba(78,205,196,0.12); color: #4ECDC4; border: 1px solid rgba(78,205,196,0.25); }
        .status-inactive { background: rgba(255,76,96,0.1);   color: #FF4C60; border: 1px solid rgba(255,76,96,0.22); }

        /* ── ERRORS ── */
        .errors-box {
            background: rgba(255,76,96,0.07);
            border: 1px solid rgba(255,76,96,0.2);
            border-radius: 20px; padding: 1.2rem 1.5rem;
        }

        .errors-box ul { list-style: none; display: flex; flex-direction: column; gap: 0.4rem; }

        .errors-box li {
            font-size: 0.82rem; color: #FF4C60;
            display: flex; align-items: center; gap: 0.5rem;
        }

        .errors-box li::before { content: '⚠'; font-size: 0.75rem; }

        /* ── ACTION BUTTONS AREA ── */
        .actions-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px; box-shadow: var(--card-shadow);
            padding: 1.8rem 2.4rem;
            display: flex; align-items: center;
            justify-content: space-between; flex-wrap: wrap; gap: 1rem;
            position: relative; overflow: hidden;
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
        }

        .actions-card::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.12), transparent 50%);
            opacity: 0; transition: opacity 0.5s; pointer-events: none; z-index: 0;
        }

        .actions-card:hover::before { opacity: 1; }

        .actions-card::after {
            content: ''; position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%; background: #FDCB6E; opacity: 0.5; z-index: 1;
        }

        .actions-inner { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 1rem; }

        .action-hint { font-size: 0.8rem; color: var(--text-soft); }

        .btn-save {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white; border: none; border-radius: 50px;
            padding: 0.9rem 2.8rem;
            font-family: 'Inter', sans-serif; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s ease; letter-spacing: 0.3px;
        }

        .btn-save:hover {
            transform: scale(1.06) translateY(-3px); filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        .btn-delete {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white; border: none; border-radius: 50px;
            padding: 0.9rem 2rem;
            font-family: 'Inter', sans-serif; font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s ease;
        }

        .btn-delete:hover {
            transform: scale(1.06) translateY(-3px); filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #FF4C6080;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            /* .menu-area handled by common.css */
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
            .form-inner { padding: 1.5rem; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; }
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
                <div class="page-title">Edit <span>Employee</span></div>
                <div class="emp-pill">{{ $user->name }}</div>
            </div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            @if ($errors->any())
            <div class="errors-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('UpdateEmpDetails') }}" method="post" id="edit_form">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{ $user->id }}">

                <!-- ── PERSONAL INFO ── -->
                <div class="glass-card card-dot-purple" id="card1" style="margin-bottom:1.5rem">
                    <div class="form-inner">
                        <div class="section-label lbl-purple">Personal Information</div>
                        <div class="form-grid-2">
                            <div class="field">
                                <label class="field-label" for="name">Full Name</label>
                                <input class="field-input" type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Full name" required>
                            </div>
                            <div class="field">
                                <label class="field-label" for="email">Email Address</label>
                                <input class="field-input" type="email" name="email" id="email" value="{{ $user->email }}" placeholder="Email" required>
                            </div>
                            <div class="field">
                                <label class="field-label" for="mobile">Mobile Number</label>
                                <input class="field-input" type="text" name="mobile" id="mobile" value="{{ $user->mobile }}" placeholder="Mobile">
                            </div>
                            <div class="field">
                                <label class="field-label" for="qualification">Qualification</label>
                                <input class="field-input" type="text" name="qualification" id="qualification" value="{{ $user->qualification }}" placeholder="Qualification">
                            </div>
                            <div class="field col-span-2">
                                <label class="field-label" for="address">Address</label>
                                <input class="field-input" type="text" name="address" id="address" value="{{ $user->address }}" placeholder="Full address">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── PROFESSIONAL DETAILS ── -->
                <div class="glass-card card-dot-teal" id="card2" style="margin-bottom:1.5rem">
                    <div class="form-inner">
                        <div class="section-label lbl-teal">Professional Details</div>
                        <div class="form-grid-3">
                            <div class="field">
                                <label class="field-label" for="post">Post / Role</label>
                                <input class="field-input" type="text" name="post" id="post" value="{{ $user->post }}" placeholder="Job role">
                            </div>
                            <div class="field">
                                <label class="field-label" for="experience">Experience (yrs)</label>
                                <input class="field-input" type="text" name="experience" id="experience" value="{{ $user->experience }}" placeholder="e.g. 3">
                            </div>
                            <div class="field">
                                <label class="field-label" for="joining">Joining Date</label>
                                <input class="field-input" type="date" name="joining" id="joining" value="{{ $user->joining }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── WORKING SCHEDULE ── -->
                <div class="glass-card card-dot-gold" id="card3" style="margin-bottom:1.5rem">
                    <div class="form-inner">
                        <div class="section-label lbl-gold">Working Schedule</div>
                        <div class="form-grid-2">
                            <div class="field">
                                <label class="field-label" for="working_from">Shift Start</label>
                                <input class="field-input" type="time" name="working_from" id="working_from" value="{{ $user->working_from }}">
                            </div>
                            <div class="field">
                                <label class="field-label" for="working_to">Shift End</label>
                                <input class="field-input" type="time" name="working_to" id="working_to" value="{{ $user->working_to }}">
                            </div>
                        </div>

                        <div class="card-divider" style="margin: 1.2rem 0;"></div>

                        <div class="toggle-row">
                            <span class="toggle-label-text">Employment Status</span>
                            <input type="hidden" name="working" value="0">
                            <label class="toggle-wrap">
                                <input type="checkbox" name="working" id="working" value="1" {{ $user->working ? 'checked' : '' }}>
                                <span class="toggle-track"></span>
                            </label>
                            <span class="status-pill {{ $user->working ? 'status-active' : 'status-inactive' }}" id="statusPill">
                                {{ $user->working ? '● Active' : '● Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

            </form>

            <!-- ── ACTIONS CARD ── -->
            <div class="actions-card" id="actionsCard">
                <div class="actions-inner">
                    <span class="action-hint">💾 Save changes or permanently delete this employee.</span>
                    <div style="display:flex;gap:1rem;flex-wrap:wrap">
                        <button type="button" class="btn-save" id="saveBtn" onclick="document.getElementById('edit_form').submit()">✓ Save Changes</button>

                        <form action="/delete_employee" method="post" id="deleteForm"
                              onsubmit="return confirm('Are you sure you want to permanently delete this employee?')">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="btn-delete" id="deleteBtn">🗑 Delete Employee</button>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->
</div><!-- /app -->


<script>
    /* ── TOASTR ── */
    toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-bottom-right' };

    /* ── THEME ── */
    const lightBtn = document.querySelector('[data-theme="light"]');
    const darkBtn  = document.querySelector('[data-theme="dark"]');

    function setTheme(theme, notify = true) {
        document.body.classList.toggle('dark', theme === 'dark');
        lightBtn.classList.toggle('active', theme === 'light');
        darkBtn.classList.toggle('active',  theme === 'dark');
        localStorage.setItem('theme', theme);
        if (notify) toastr.info(`${theme} mode`, '', { timeOut: 900 });
    }

    lightBtn.addEventListener('click', () => setTheme('light'));
    darkBtn.addEventListener('click',  () => setTheme('dark'));
    setTheme(localStorage.getItem('theme') || 'light', false);

    /* ── MOUSE GLOW ── */
    ['card1','card2','card3','actionsCard'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('mousemove', e => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            el.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── BUTTON CLICK FEEDBACK ── */
    ['saveBtn','deleteBtn'].forEach(id => {
        const btn = document.getElementById(id);
        if (!btn) return;
        btn.addEventListener('click', () => {
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => btn.style.transform = '', 200);
        });
    });

    /* ── EMPLOYMENT STATUS TOGGLE ── */
    const workingCheckbox = document.getElementById('working');
    const statusPill      = document.getElementById('statusPill');

    workingCheckbox.addEventListener('change', () => {
        if (workingCheckbox.checked) {
            statusPill.textContent = '● Active';
            statusPill.className   = 'status-pill status-active';
        } else {
            statusPill.textContent = '● Inactive';
            statusPill.className   = 'status-pill status-inactive';
        }
    });

    /* ── SHOW VALIDATION ERRORS AS TOASTS ── */
    document.querySelectorAll('.errors-box li').forEach(el => {
        toastr.error(el.textContent.trim());
    });
</script>
</body>
</html>