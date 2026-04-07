<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Overtime • Checkout</title>
    <x-link />

    <style>
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
            /* .menu-area handled by common.css */
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
            <div class="page-title"><i class="fa-solid fa-clock" style="color:#FDCB6E;"></i> Overtime &amp; <span>Late Checkout</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- warning banner -->
            <div class="warning-banner glow-pulse">
                <div class="warning-icon"><i class="fa-solid fa-triangle-exclamation" style="color:#FF4C60;"></i></div>
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


<script>
    /* ── TOASTR ── */

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
                tbody.innerHTML = '<tr class="empty-row"><td colspan="6"><i class="fa-solid fa-check" style="color:#2ecc71;"></i> No pending checkouts right now.</td></tr>';
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
                            <button type="submit" class="checkout-btn"><i class="fa-solid fa-right-from-bracket" style="color:#fff;"></i> Checkout</button>
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
                        toastr.success(result.success || 'Checkout recorded');
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