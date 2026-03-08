<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Overtime • Checkout</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
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
            --row-hover:         rgba(255,76,96,0.04);
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
            --row-hover:         rgba(255,76,96,0.07);
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
        .content { padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; overflow-y: auto; }

        /* ── WARNING BANNER ── */
        .warning-banner {
            background: linear-gradient(135deg, rgba(255,76,96,0.1), rgba(249,17,121,0.07));
            border: 1px solid rgba(255,76,96,0.25);
            border-radius: 24px;
            padding: 1.1rem 1.8rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            backdrop-filter: blur(10px);
        }

        .warning-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .warning-text {
            font-size: 0.92rem;
            font-weight: 600;
            color: #FF4C60;
            letter-spacing: 0.2px;
        }

        /* ── SECTION HEADER ── */
        .section-header {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0 0.5rem;
        }

        .section-header::before {
            content: '';
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #F91179);
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative;
            overflow: hidden;
        }

        .table-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.12), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .table-card:hover::before { opacity: 1; }

        .table-card::after {
            content: '';
            position: absolute;
            top: 1rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 20px;
            background: #FF4C60;
            opacity: 0.5;
            z-index: 1;
        }

        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }

        thead tr {
            background: linear-gradient(135deg, rgba(255,76,96,0.07), rgba(249,17,121,0.04));
            border-bottom: 1px solid var(--card-border);
        }

        th {
            padding: 1.1rem 1.4rem;
            text-align: left;
            font-size: 0.72rem;
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
            padding: 1rem 1.4rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            vertical-align: middle;
        }

        td.name-cell {
            font-weight: 600;
            color: var(--text-primary);
        }

        td.sr-cell {
            font-family: 'Space Grotesk', monospace;
            color: var(--text-soft);
            font-size: 0.82rem;
            width: 60px;
        }

        td.time-cell {
            font-family: 'Space Grotesk', monospace;
            font-size: 0.88rem;
            color: #FDCB6E;
            font-weight: 500;
        }

        td.email-cell {
            font-size: 0.83rem;
            color: var(--text-soft);
        }

        td.mobile-cell {
            font-family: 'Space Grotesk', monospace;
            font-size: 0.85rem;
        }

        /* ── INLINE CHECKOUT FORM ── */
        .checkout-form {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            flex-wrap: wrap;
        }

        .dt-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 50px;
            padding: 0.5rem 1.1rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.82rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(6px);
            min-width: 190px;
        }

        .dt-input:focus {
            border-color: rgba(255,76,96,0.4);
            box-shadow: 0 0 0 3px rgba(255,76,96,0.1);
        }

        .dt-input::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }

        .checkout-btn {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            letter-spacing: 0.3px;
        }

        .checkout-btn:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #FF4C6080;
        }

        /* ── EMPTY / LOADING ── */
        .empty-row td {
            padding: 3.5rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        /* ── GLOW PULSE (warning banner) ── */
        @keyframes soft-pulse {
            0%   { box-shadow: 0 0 10px rgba(255,76,96,0.1), 0 0 20px rgba(255,76,96,0.05); }
            100% { box-shadow: 0 0 25px rgba(255,76,96,0.25), 0 0 40px rgba(255,76,96,0.1); }
        }

        .glow-pulse { animation: soft-pulse 3s infinite alternate; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .menu-area { width: 80px; }
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; flex-wrap: wrap; gap: 0.8rem; }
            .checkout-form { flex-direction: column; align-items: stretch; }
            .dt-input { min-width: unset; width: 100%; }
        }
    </style>
</head>

<body class="">
<div class="app">

    <x-employee-menu />

    <!-- ── MAIN ── -->
    <div class="main">

        <!-- header -->
        <div class="header-area">
            <div class="page-title">⏱ Overtime &amp; <span>Late Checkout</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light">☀️ light</button>
                <button class="theme-option" data-theme="dark">🌙 dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- warning banner -->
            <div class="warning-banner glow-pulse">
                <div class="warning-icon">⚠️</div>
                <div class="warning-text">Marking a false checkout is a punishable offence. All submissions are logged and reviewed.</div>
            </div>

            <!-- table -->
            <div class="section-header">Pending Checkouts</div>
            <div class="table-card" id="tableCard">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Check In</th>
                                <th>Submit Checkout</th>
                            </tr>
                        </thead>
                        <tbody id="checkout">
                            <tr class="empty-row"><td colspan="6">Loading pending checkouts…</td></tr>
                        </tbody>
                    </table>
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
    const tableCard = document.getElementById('tableCard');
    tableCard.addEventListener('mousemove', e => {
        const r = tableCard.getBoundingClientRect();
        tableCard.style.setProperty('--x', ((e.clientX - r.left) / r.width * 100) + '%');
        tableCard.style.setProperty('--y', ((e.clientY - r.top) / r.height * 100) + '%');
    });

    /* ── FETCH DATA ── */
    let formEventListenersAttached = false;

    document.addEventListener('DOMContentLoaded', FetchData);

    async function FetchData() {
        const tbody = document.getElementById('checkout');
        tbody.innerHTML = '<tr class="empty-row"><td colspan="6">Loading…</td></tr>';

        try {
            const response = await fetch('/late_checkouts');
            const result   = await response.json();

            if (!response.ok) {
                toastr.error(result.error);
                return;
            }

            tbody.innerHTML = '';

            if (!result.attendance.length) {
                tbody.innerHTML = '<tr class="empty-row"><td colspan="6">🎉 No pending checkouts right now.</td></tr>';
                return;
            }

            let srno = 1;
            result.attendance.forEach(i => {
                const n = srno++;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="sr-cell">${n}</td>
                    <td class="name-cell">${i.user.name}</td>
                    <td class="email-cell">${i.user.email}</td>
                    <td class="mobile-cell">${i.user.mobile}</td>
                    <td class="time-cell">${new Date(i.checkin).toLocaleString('en-GB', { hour12: true })}</td>
                    <td>
                        <form class="checkout-form" id="lateCheckoutForm${n}">
                            <input type="hidden" name="id" value="${i.id}" required />
                            <input class="dt-input" type="datetime-local" name="checkout" id="${n}checkout" required />
                            <button type="submit" class="checkout-btn">👋 Checkout</button>
                        </form>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            if (!formEventListenersAttached) {
                attachFormEventListeners(result.attendance);
                formEventListenersAttached = true;
            }

        } catch (err) {
            toastr.error(String(err));
        }
    }

    function attachFormEventListeners(attendanceData) {
        attendanceData.forEach((item, index) => {
            const formId = `lateCheckoutForm${index + 1}`;
            const form   = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', async e => {
                e.preventDefault();

                const btn = form.querySelector('.checkout-btn');
                btn.style.transform = 'scale(0.96)';
                setTimeout(() => btn.style.transform = '', 200);

                try {
                    const response = await fetch('/after_checkouts', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                        body: new FormData(e.target),
                    });
                    const result = await response.json();

                    if (response.ok) {
                        formEventListenersAttached = false;
                        FetchData();
                        toastr.success(result.success || '✅ Checkout recorded');
                    } else {
                        toastr.error(result.error);
                    }
                } catch (err) {
                    toastr.error(String(err));
                }
            });
        });
    }
</script>
</body>
</html>