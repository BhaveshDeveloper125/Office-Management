<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Holidays • Management</title>
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
            --row-hover:         rgba(108,99,255,0.04);
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
            --row-hover:         rgba(108,99,255,0.08);
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
            gap: 2.5rem;
        }

        /* ── TWO-COL LAYOUT ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 1100px) { .two-col { grid-template-columns: 1fr; } }

        /* ── SECTION HEADER ── */
        .section-header {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-soft);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0 0.5rem;
            margin-bottom: 1rem;
        }

        .section-header::before {
            content: '';
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #F91179);
        }

        .section-header.purple::before { background: linear-gradient(135deg, #6C63FF, #4a43d9); }
        .section-header.teal::before   { background: linear-gradient(135deg, #4ECDC4, #2fb8af); }
        .section-header.gold::before   { background: linear-gradient(135deg, #FDCB6E, #e0a940); }

        /* ── GLASS CARD ── */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.13), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .glass-card:hover::before { opacity: 1; }

        /* accent dots cycling */
        .glass-card:nth-of-type(1)::after { background: #FF4C60; }
        .glass-card:nth-of-type(2)::after { background: #6C63FF; }
        .glass-card:nth-of-type(3)::after { background: #4ECDC4; }
        .glass-card:nth-of-type(4)::after { background: #FDCB6E; }

        .glass-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            opacity: 0.5;
            z-index: 1;
        }

        /* ── FORM INNER ── */
        .form-inner {
            padding: 2rem 2.2rem;
            position: relative;
            z-index: 1;
        }

        .form-section-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 1.2rem;
        }

        .field { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1rem; }

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
            border-color: rgba(108,99,255,0.4);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        .field-input::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }

        .field-textarea {
            resize: vertical;
            min-height: 85px;
            border-radius: 20px;
        }

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

        /* ── DATE ROW ── */
        .date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        /* ── BUTTON GROUP ── */
        .btn-group {
            display: flex;
            gap: 0.8rem;
            margin-top: 1.2rem;
            flex-wrap: wrap;
        }

        .btn-add {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-add:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        .btn-remove {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.92rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-remove:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #FF4C6080;
        }

        /* ── HINT TEXT ── */
        .hint-text {
            font-size: 0.78rem;
            color: #FF4C60;
            opacity: 0.8;
            margin-top: 0.6rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* ── TABLE CARD ── */
        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }

        thead tr {
            background: linear-gradient(135deg, rgba(108,99,255,0.07), rgba(255,76,96,0.04));
            border-bottom: 1px solid var(--card-border);
        }

        th {
            padding: 1rem 1.2rem;
            text-align: left;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: var(--text-soft);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--card-border);
            transition: background 0.2s ease;
        }

        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--row-hover); }

        td {
            padding: 0.9rem 1.2rem;
            color: var(--text-secondary);
            font-size: 0.88rem;
            vertical-align: middle;
        }

        td.sr-cell  { font-family: 'Space Grotesk', monospace; font-size: 0.8rem; color: var(--text-soft); }
        td.day-cell { font-weight: 600; color: var(--text-primary); }
        td.mono-cell { font-family: 'Space Grotesk', monospace; font-size: 0.84rem; }

        .day-chip {
            display: inline-block;
            background: rgba(78,205,196,0.12);
            color: #4ECDC4;
            border: 1px solid rgba(78,205,196,0.25);
            border-radius: 20px;
            padding: 0.22rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .title-cell { font-weight: 600; color: var(--text-primary); }
        .desc-cell  { color: var(--text-soft); font-size: 0.82rem; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .days-badge {
            font-family: 'Space Grotesk', monospace;
            font-weight: 700;
            font-size: 0.95rem;
            background: linear-gradient(135deg, #FF4C60, #F91179);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* empty state */
        .empty-row td {
            padding: 2.5rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        /* row entrance */
        @keyframes row-in {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        tbody tr { animation: row-in 0.28s ease both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .menu-area { width: 80px; }
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
            .date-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; }
            .btn-group { flex-direction: column; }
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
            <div class="page-title">🏖 Holiday <span>Management</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light">☀️ light</button>
                <button class="theme-option" data-theme="dark">🌙 dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- ── ROW 1: Weekend management ── -->
            <div class="two-col">

                <!-- weekend form -->
                <div>
                    <div class="section-header teal">Weekend Management</div>
                    <div class="glass-card" id="weekendFormCard">
                        <div class="form-inner">
                            <form id="WeekendHolidayForm">
                                <div class="field">
                                    <label class="field-label" for="date">Select Day</label>
                                    <div class="select-wrap">
                                        <select class="field-select" name="day" id="date" required>
                                            <option value="" disabled selected>Select a Day</option>
                                            @foreach (config('WeeklyHoliday.days') as $key => $value)
                                                <option value="{{ $value }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-add" id="add">➕ Add Weekend</button>
                                    <button type="button" class="btn-remove" id="remove">🗑 Remove Weekend</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- weekend table -->
                <div>
                    <div class="section-header teal">Current Weekends</div>
                    <div class="glass-card" id="weekendTableCard">
                        <div class="table-wrap">
                            <table>
                                <thead><tr>
                                    <th>#</th>
                                    <th>Day</th>
                                </tr></thead>
                                <tbody id="WeekendTable">
                                    <tr class="empty-row"><td colspan="2">Loading…</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── ROW 2: Holiday management ── -->
            <div class="two-col">

                <!-- holiday form -->
                <div>
                    <div class="section-header gold">Set Holiday</div>
                    <div class="glass-card" id="holidayFormCard">
                        <div class="form-inner">
                            <form id="HolidayForm">
                                <div class="date-row">
                                    <div class="field">
                                        <label class="field-label" for="from">From Date</label>
                                        <input class="field-input" type="date" name="from" id="from" required>
                                    </div>
                                    <div class="field">
                                        <label class="field-label" for="to">To Date</label>
                                        <input class="field-input" type="date" name="to" id="to" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="field-label" for="title">Holiday Title</label>
                                    <input class="field-input" type="text" name="title" id="title" placeholder="e.g. Diwali, Christmas…" required>
                                </div>
                                <div class="field">
                                    <label class="field-label" for="description">Description</label>
                                    <textarea class="field-textarea" name="description" id="description" placeholder="Optional description…"></textarea>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn-add" id="add_holiday">🌟 Set Holiday</button>
                                    <button type="button" class="btn-remove" id="remove_holiday">🗑 Remove Holiday</button>
                                </div>
                                <div class="hint-text">⚠️ Enter the exact same date range to remove a holiday.</div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- holiday table -->
                <div>
                    <div class="section-header gold">Scheduled Holidays</div>
                    <div class="glass-card" id="holidayTableCard">
                        <div class="table-wrap">
                            <table>
                                <thead><tr>
                                    <th>#</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Days</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                </tr></thead>
                                <tbody id="HolidayTable">
                                    <tr class="empty-row"><td colspan="6">Loading…</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
    ['weekendFormCard','weekendTableCard','holidayFormCard','holidayTableCard'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('mousemove', e => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            el.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── BUTTON CLICK FEEDBACK ── */
    function addClickFeedback(id) {
        const btn = document.getElementById(id);
        if (!btn) return;
        btn.addEventListener('click', () => {
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => btn.style.transform = '', 200);
        });
    }
    ['add','remove','add_holiday','remove_holiday'].forEach(addClickFeedback);

    /* ── CSRF ── */
    const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ──────────────────────────────────────────
       WEEKEND APIs
    ────────────────────────────────────────── */

    /* Add Weekend */
    document.getElementById('add').addEventListener('click', async () => {
        const formData = new FormData(document.getElementById('WeekendHolidayForm'));
        try {
            const res    = await fetch('/add_weekend', { method: 'POST', body: formData });
            const result = await res.json();
            res.ok ? (GetWeekends(), toastr.success(result.success)) : toastr.error(result.error);
        } catch (e) { toastr.error(String(e)); }
    });

    /* Remove Weekend */
    document.getElementById('remove').addEventListener('click', async () => {
        const formData = new FormData(document.getElementById('WeekendHolidayForm'));
        formData.append('_method', 'DELETE');
        try {
            const res    = await fetch('/remove_weekend', { method: 'POST', body: formData });
            const result = await res.json();
            res.ok ? (GetWeekends(), toastr.success(result.success)) : toastr.error(result.error);
        } catch (e) { toastr.error(String(e)); }
    });

    /* Fetch Weekends */
    async function GetWeekends() {
        try {
            const res    = await fetch('/weekend');
            const result = await res.json();
            const tbody  = document.getElementById('WeekendTable');
            tbody.innerHTML = '';

            if (!res.ok) { toastr.error(result.error); return; }

            if (!result.Days.length) {
                tbody.innerHTML = '<tr class="empty-row"><td colspan="2">No weekends configured.</td></tr>';
                return;
            }

            result.Days.forEach((day, i) => {
                const tr = document.createElement('tr');
                tr.style.animationDelay = `${i * 50}ms`;
                tr.innerHTML = `<td class="sr-cell">${i + 1}</td><td><span class="day-chip">${day}</span></td>`;
                tbody.appendChild(tr);
            });
        } catch (e) { toastr.error(String(e)); }
    }

    /* ──────────────────────────────────────────
       HOLIDAY APIs
    ────────────────────────────────────────── */

    /* Add Holiday */
    document.getElementById('add_holiday').addEventListener('click', async () => {
        const body = new FormData(document.getElementById('HolidayForm'));
        try {
            const res    = await fetch('/set_holiday', { method: 'POST', body });
            const result = await res.json();
            res.ok ? (toastr.success(result.success), GetHoliday()) : toastr.error(result.error);
        } catch (e) { toastr.error(String(e)); }
    });

    /* Remove Holiday */
    document.getElementById('remove_holiday').addEventListener('click', async () => {
        const body = new FormData(document.getElementById('HolidayForm'));
        body.append('_method', 'DELETE');
        try {
            const res    = await fetch('/remove_holiday', { method: 'POST', body });
            const result = await res.json();
            res.ok ? (toastr.success(result.success), GetHoliday()) : toastr.error(result.error);
        } catch (e) { toastr.error(String(e)); }
    });

    /* Fetch Holidays */
    async function GetHoliday() {
        try {
            const res    = await fetch('/holidays');
            const result = await res.json();
            const tbody  = document.getElementById('HolidayTable');
            tbody.innerHTML = '';

            if (!res.ok) { toastr.error(result.error); return; }

            const holidays = result.Holiday?.data || [];

            if (!holidays.length) {
                tbody.innerHTML = '<tr class="empty-row"><td colspan="6">No holidays scheduled yet.</td></tr>';
                return;
            }

            holidays.forEach((i, idx) => {
                const tr = document.createElement('tr');
                tr.style.animationDelay = `${idx * 40}ms`;
                tr.innerHTML = `
                    <td class="sr-cell">${idx + 1}</td>
                    <td class="mono-cell">${i.from}</td>
                    <td class="mono-cell">${i.to}</td>
                    <td><span class="days-badge">${i.days}</span></td>
                    <td class="title-cell">${i.title}</td>
                    <td class="desc-cell" title="${i.description}">${i.description || '—'}</td>
                `;
                tbody.appendChild(tr);
            });
        } catch (e) { toastr.error(String(e)); }
    }

    /* ── INIT ── */
    document.addEventListener('DOMContentLoaded', () => {
        GetWeekends();
        GetHoliday();
    });
</script>
</body>
</html>