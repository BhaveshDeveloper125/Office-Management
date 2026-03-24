<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin • Dashboard</title>
    <x-link />

    <style>
        /* ── STATS GRID ── */

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 700px)  { .stats-grid { grid-template-columns: 1fr; } }

        /* ── STAT CARD ── */
        .stat-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            padding: 2rem 1.8rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative;
            overflow: hidden;
            cursor: default;
        }

        /* light refraction overlay */
        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.15), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .stat-card:hover { transform: translateY(-8px) scale(1.02); border-color: #FF4C6040; box-shadow: 0 40px 70px -20px rgba(255,76,96,0.3), var(--card-shadow); }
        .stat-card:hover::before { opacity: 1; }

        /* accent dots — cycling per design system */
        .stat-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            opacity: 0.55;
            z-index: 1;
        }

        .stat-card:nth-child(1)::after { background: #FF4C60; }
        .stat-card:nth-child(2)::after { background: #6C63FF; }
        .stat-card:nth-child(3)::after { background: #4ECDC4; }
        .stat-card:nth-child(4)::after { background: #FDCB6E; }
        .stat-card:nth-child(5)::after { background: #F91179; }
        .stat-card:nth-child(6)::after { background: #6C63FF; }
        .stat-card:nth-child(7)::after { background: #4ECDC4; }

        .stat-inner { position: relative; z-index: 1; }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 1rem;
        }

        .stat-value {
            font-family: 'Space Grotesk', monospace;
            font-size: 3.6rem;
            font-weight: 700;
            line-height: 1;
            background: var(--stat-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: transform 0.2s;
            min-height: 3.8rem;
            display: block;
        }

        .stat-card:hover .stat-value { transform: scale(1.03); }

        /* count-up shimmer on load */
        @keyframes value-in {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-value.loaded { animation: value-in 0.4s cubic-bezier(0.2,0.9,0.4,1) both; }
    </style>
</head>

<body class="">
<div class="app">

    <x-side-bar-menu />

    <!-- ── MAIN ── -->
    <div class="main">

        <!-- header -->
        <div class="header-area">
            <div class="page-title"><i class="fa-solid fa-chart-bar" style="color:#6C63FF;"></i> Admin <span>Dashboard</span></div>
            <div class="header-right">
                <div class="clock-pill" id="liveClock">00:00:00</div>
                <div class="theme-toggle">
                    <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                    <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
                </div>
            </div>
        </div>

        <!-- content -->
        <div class="content">
            <div class="section-header">Today's Overview</div>

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Total Employees</div>
                        <span class="stat-value" id="totalEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Late Today</div>
                        <span class="stat-value" id="lateEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Present Today</div>
                        <span class="stat-value" id="presentEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">On Leave Today</div>
                        <span class="stat-value" id="leaveEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Absent Today</div>
                        <span class="stat-value" id="absentEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Early Leave Today</div>
                        <span class="stat-value" id="earlyLeaveEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Holiday This Month</div>
                        <span class="stat-value" id="holidayEmp">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Requested Leaves</div>
                        <span class="stat-value" id="requestedLeaves" style="background: none; -webkit-text-fill-color: #FF4C60; color: #FF4C60;">—</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-label">Paye Leave Request</div>
                        <span class="stat-value" id="payLeavesRequest" style="background: none; -webkit-text-fill-color: #FF4C60; color: #FF4C60;">—</span>
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

    /* ── LIVE CLOCK ── */
    function updateClock() {
        document.getElementById('liveClock').textContent =
            new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateClock, 1000);
    updateClock();

    /* ── MOUSE GLOW ── */
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            card.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            card.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── SET VALUE HELPER ── */
    function setVal(id, val) {
        const el = document.getElementById(id);
        el.textContent = val ?? '—';
        el.classList.add('loaded');
    }

    /* ── FETCH CARD DATA ── */
    document.addEventListener('DOMContentLoaded', GetCardDetails);

    async function GetCardDetails() {
        try {
            const response = await fetch('/admin_cards_data');
            const data     = await response.json();console.log(data);

            if (response.ok) {
                // staggered reveal
                const entries = [
                    ['totalEmp',      data.totalEmp],
                    ['lateEmp',       data.lateToday],
                    ['presentEmp',    data.presentToday],
                    ['leaveEmp',      data.leaveToday],
                    ['absentEmp',     data.absentToday],
                    ['earlyLeaveEmp', data.earlyLeave],
                    ['holidayEmp',    data.overallHoliday],
                    ['requestedLeaves', data.requestedLeaves],
                    ['payLeavesRequest', data.payLeave],
                ];

                entries.forEach(([id, val], i) => {
                    setTimeout(() => setVal(id, val), i * 80);
                });
            } else {
                toastr.error(data.error || 'Failed to fetch card details');
            }
        } catch (e) {
            toastr.error(String(e));
        }
    }
</script>
</body>
</html>