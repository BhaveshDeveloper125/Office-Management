<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin • Dashboard</title>
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
            --stat-gradient:     linear-gradient(135deg, #1b1f2c 0%, #4d5466 100%);
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
            --stat-gradient:     linear-gradient(135deg, #ffffff 0%, #c7cbff 100%);
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

        /* header right: clock + toggle */
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .clock-pill {
            background: var(--toggle-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--toggle-border);
            border-radius: 80px;
            padding: 0.45rem 1.4rem;
            font-family: 'Space Grotesk', monospace;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 2px;
            background-clip: text;
            -webkit-background-clip: unset;
            color: var(--text-secondary);
            transition: all 0.3s;
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
        .content { padding: 2.5rem; overflow-y: auto; }

        /* ── SECTION LABEL ── */
        .section-header {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-soft);
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .section-header::before {
            content: '';
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #F91179);
        }

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

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .menu-area { width: 80px; }
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
            .clock-pill { display: none; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; flex-wrap: wrap; gap: 0.8rem; }
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
            <div class="page-title">📊 Admin <span>Dashboard</span></div>
            <div class="header-right">
                <div class="clock-pill" id="liveClock">00:00:00</div>
                <div class="theme-toggle">
                    <button class="theme-option active" data-theme="light">☀️ light</button>
                    <button class="theme-option" data-theme="dark">🌙 dark</button>
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
            const data     = await response.json();

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