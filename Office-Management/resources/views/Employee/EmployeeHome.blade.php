<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <x-link />
    <style>
            *,
            *::before,
            *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            :root {
                --bg-gradient-start: #f0f3fa;
                --bg-gradient-end: #e9eef5;
                --card-bg: rgba(255, 255, 255, 0.75);
                --card-border: rgba(255, 255, 255, 0.5);
                --card-shadow: 0 25px 50px -18px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.7) inset;
                --text-primary: #1b1f2c;
                --text-secondary: #4d5466;
                --text-soft: #7b8395;
                --clock-bg: rgba(255, 255, 255, 0.5);
                --header-bg: rgba(255, 255, 255, 0.4);
                --menu-bg: rgba(255, 255, 255, 0.3);
                --stat-gradient: linear-gradient(135deg, #1b1f2c 0%, #4d5466 100%);
                --toggle-bg: rgba(255, 255, 255, 0.4);
                --toggle-border: rgba(255, 255, 255, 0.6);
                --card-backdrop: blur(16px);
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
                --clock-bg: rgba(15, 15, 28, 0.6);
                --header-bg: rgba(10, 10, 22, 0.5);
                --menu-bg: rgba(10, 10, 22, 0.5);
                --stat-gradient: linear-gradient(135deg, #ffffff 0%, #c7cbff 100%);
                --toggle-bg: rgba(30, 30, 50, 0.6);
                --toggle-border: rgba(255, 255, 255, 0.1);
                --card-backdrop: blur(20px);
            }

            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(145deg, var(--bg-gradient-start), var(--bg-gradient-end));
                min-height: 100vh;
                color: var(--text-primary);
                transition: background-color 0.4s cubic-bezier(0.2, 0.9, 0.3, 1), color 0.3s ease;
                display: flex;
            }

            /* ── SIDEBAR ── */
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
                transition: background 0.3s ease, border-color 0.3s ease;
            }

            .logo {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 2rem;
                font-weight: 600;
                letter-spacing: -0.02em;
                background: linear-gradient(130deg, #FF4C60, #6C63FF);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 2rem;
                padding: 0 0.5rem;
            }

            .menu-item {
                display: flex;
                align-items: center;
                gap: 0.8rem;
                padding: 0.85rem 1rem;
                border-radius: 20px;
                color: var(--text-secondary);
                text-decoration: none;
                font-size: 0.95rem;
                font-weight: 500;
                cursor: pointer;
                border: 1px solid transparent;
                transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1);
            }

            .menu-item:hover {
                transform: translateX(6px);
                background: var(--card-bg);
                border: 1px solid var(--card-border);
                color: var(--text-primary);
            }

            .menu-item.active {
                background: var(--card-bg);
                border: 1px solid var(--card-border);
                color: var(--text-primary);
            }

            .menu-icon {
                width: 22px;
                height: 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
            }

            /* ── MAIN ── */
            .main {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            /* ── HEADER ── */
            .header {
                position: sticky;
                top: 0;
                z-index: 100;
                background: var(--header-bg);
                backdrop-filter: var(--card-backdrop);
                border-bottom: 1px solid var(--card-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 2rem;
                transition: background 0.3s ease;
            }

            .header-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 1.3rem;
                font-weight: 600;
                color: var(--text-primary);
            }

            .header-right {
                display: flex;
                align-items: center;
                gap: 1.2rem;
            }

            .theme-toggle {
                display: flex;
                background: var(--toggle-bg);
                border: 1px solid var(--toggle-border);
                border-radius: 60px;
                padding: 0.3rem;
                gap: 0.2rem;
                transition: background 0.3s ease;
            }

            .toggle-pill {
                padding: 0.4rem 1rem;
                border-radius: 50px;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                border: none;
                background: transparent;
                color: var(--text-secondary);
                transition: all 0.25s ease;
            }

            .toggle-pill.active {
                background: #FF4C60;
                color: white;
                box-shadow: 0 6px 14px #FF4C6080;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50px;
                background: linear-gradient(135deg, #FF4C60, #6C63FF);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 700;
                font-size: 0.9rem;
                font-family: 'Space Grotesk', sans-serif;
            }

            /* ── CONTENT ── */
            .content {
                padding: 2rem;
                flex: 1;
            }

            /* ── STAT CARDS GRID ── */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            @media (max-width: 1100px) {
                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 700px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }
            }

            .stat-card {
                background: var(--card-bg);
                backdrop-filter: var(--card-backdrop);
                border: 1px solid var(--card-border);
                box-shadow: var(--card-shadow);
                border-radius: 36px;
                padding: 1.6rem 1.8rem;
                cursor: pointer;
                text-decoration: none;
                display: block;
                position: relative;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1);
            }

            .stat-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(800px circle at var(--x, 50%) var(--y, 0%), rgba(255, 255, 255, 0.15), transparent 50%);
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
                border-radius: inherit;
            }

            .stat-card:hover::before {
                opacity: 1;
            }

            .stat-card:hover {
                transform: translateY(-8px) scale(1.02);
                border-color: #FF4C6040;
                box-shadow: 0 40px 70px -20px rgba(255, 76, 96, 0.3), var(--card-shadow);
            }

            /* Accent dots */
            .stat-card::after {
                content: '';
                position: absolute;
                top: 1.2rem;
                right: 1.2rem;
                width: 10px;
                height: 10px;
                border-radius: 50%;
            }

            .stat-card:nth-child(1)::after {
                background: #FF4C60;
            }

            .stat-card:nth-child(2)::after {
                background: #6C63FF;
            }

            .stat-card:nth-child(3)::after {
                background: #4ECDC4;
            }

            .stat-card:nth-child(4)::after {
                background: #FDCB6E;
            }

            .stat-card:nth-child(5)::after {
                background: #F91179;
            }

            .stat-card:nth-child(6)::after {
                background: #6C63FF;
            }

            .stat-card:nth-child(7)::after {
                background: #4ECDC4;
            }

            .stat-card:nth-child(8)::after {
                background: #FF4C60;
            }

            .stat-label {
                font-size: 0.78rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: var(--text-soft);
                margin-bottom: 0.9rem;
                transition: color 0.3s ease;
            }

            .stat-value {
                font-family: 'Space Grotesk', monospace;
                font-size: 2.4rem;
                font-weight: 700;
                background: var(--stat-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                line-height: 1;
            }

            /* ── ACTION SECTION ── */
            .action-section {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.5rem;
            }

            @media (max-width: 700px) {
                .action-section {
                    grid-template-columns: 1fr;
                }
            }

            .action-card {
                background: var(--card-bg);
                backdrop-filter: var(--card-backdrop);
                border: 1px solid var(--card-border);
                box-shadow: var(--card-shadow);
                border-radius: 36px;
                padding: 2rem 2.2rem;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .action-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(800px circle at var(--x, 50%) var(--y, 0%), rgba(255, 255, 255, 0.12), transparent 50%);
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
                border-radius: inherit;
            }

            .action-card:hover::before {
                opacity: 1;
            }

            .action-card-label {
                font-size: 0.82rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                color: var(--text-soft);
            }

            .clock-display {
                font-family: 'Space Grotesk', monospace;
                font-size: 3rem;
                font-weight: 700;
                background: var(--stat-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                background-color: var(--clock-bg);
                padding: 1rem 1.5rem;
                border-radius: 20px;
                text-align: center;
                letter-spacing: 0.04em;
            }

            .clock-display.glow-pulse {
                animation: soft-pulse 3s infinite alternate;
            }

            @keyframes soft-pulse {
                0% {
                    box-shadow: 0 0 10px rgba(255, 76, 96, 0.1), 0 0 20px rgba(108, 99, 255, 0.1);
                }

                100% {
                    box-shadow: 0 0 25px rgba(255, 76, 96, 0.3), 0 0 40px rgba(108, 99, 255, 0.2);
                }
            }

            .btn {
                border: none;
                border-radius: 50px;
                padding: 1rem 2.8rem;
                font-size: 1.2rem;
                font-weight: 600;
                font-family: 'Inter', sans-serif;
                color: white;
                cursor: pointer;
                transition: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1);
                width: 100%;
            }

            .btn-checkin {
                background: linear-gradient(145deg, #6C63FF, #4a43d9);
            }

            .btn-checkin:hover {
                transform: scale(1.06) translateY(-3px);
                filter: brightness(1.1);
                box-shadow: 0 20px 30px -10px #6C63FF80;
            }

            .btn-checkout {
                background: linear-gradient(145deg, #FF4C60, #d43f52);
            }

            .btn-checkout:hover {
                transform: scale(1.06) translateY(-3px);
                filter: brightness(1.1);
                box-shadow: 0 20px 30px -10px #FF4C6080;
            }

            .btn:active {
                transform: scale(0.96) !important;
            }

            /* section title */
            .section-title {
                font-family: 'Space Grotesk', sans-serif;
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 1.2rem;
                transition: color 0.3s ease;
            }
    </style>
</head>

<body>

    <x-employee-menu /> 

    <!-- MAIN -->
    <div class="main">

        <!-- HEADER -->
        <header class="header">
            <div class="header-title">Employee Dashboard</div>
            <div class="header-right">
                <div class="theme-toggle">
                    <button class="toggle-pill active" id="lightBtn" onclick="setTheme('light')">☀️ Light</button>
                    <button class="toggle-pill" id="darkBtn" onclick="setTheme('dark')">🌙 Dark</button>
                </div>
                <!-- <div class="user-avatar">JD</div> -->
            </div>
        </header>

        <!-- CONTENT -->
        <div class="content">

            <!-- STAT CARDS -->
            <p class="section-title">This Month's Overview</p>
            <div class="stats-grid">
                <a class="stat-card" href="#">
                    <div class="stat-label">Attendance</div>
                    <div class="stat-value" id="attendance">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Late Arrivals</div>
                    <div class="stat-value" id="late">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Early Leave</div>
                    <div class="stat-value" id="early">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Absent</div>
                    <div class="stat-value" id="absent">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Overtime</div>
                    <div class="stat-value" id="overtime">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Holidays</div>
                    <div class="stat-value" id="holiday">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Working Days</div>
                    <div class="stat-value" id="workingdays">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Days Remaining</div>
                    <div class="stat-value" id="remainingworkingdays">—</div>
                </a>
            </div>

            <!-- ACTION CARDS -->
            <p class="section-title">Attendance Actions</p>
            <div class="action-section">

                <div class="action-card">
                    <div class="action-card-label">Check In</div>
                    <div class="clock-display glow-pulse" id="LiveClock">00:00:00</div>
                    <form id="CheckIn">
                        @csrf
                        <button type="submit" class="btn btn-checkin">✅ Check In</button>
                    </form>
                </div>

                <div class="action-card">
                    <div class="action-card-label">Check Out</div>
                    <div class="clock-display glow-pulse" id="LiveClock2">00:00:00</div>
                    <form id="CheckOut">
                        @csrf
                        <button type="submit" class="btn btn-checkout">🚪 Check Out</button>
                    </form>
                </div>

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

        (function initTheme() {
            const saved = localStorage.getItem('theme') || 'light';
            setTheme(saved);
        })();

        // ── LIVE CLOCK ──
        setInterval(() => {
            const t = new Date().toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('LiveClock').textContent = t;
            document.getElementById('LiveClock2').textContent = t;
        }, 1000);

        // ── MOUSE TRACKING GLOW ──
        document.querySelectorAll('.stat-card, .action-card').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                card.style.setProperty('--x', x + '%');
                card.style.setProperty('--y', y + '%');
            });
        });

        // ── BUTTON CLICK ANIMATION ──
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.style.transform = 'scale(0.96)';
                setTimeout(() => btn.style.transform = '', 200);
            });
        });

        // ── CHECK IN ──
        document.querySelector('#CheckIn').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/checkin', {
                    method: 'POST',
                    body: new FormData(e.target)
                });
                const result = await response.json();
                response.ok ? toastr.success(result.success) : toastr.error(result.error);
            } catch (err) {
                toastr.error('Check-in failed: ' + err.message);
                console.log(err);
            }
        });

        // ── CHECK OUT ──
        document.querySelector('#CheckOut').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/checkout', {
                    method: 'POST',
                    body: new FormData(e.target)
                });
                const result = await response.json();
                response.ok ? toastr.success(result.success) : toastr.error(result.error);
            } catch (err) {
                toastr.error('Check-out failed: ' + err.message);
            }
        });

        // ── CARDS DATA ──
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const r = await fetch('/current_month_attendace_summary');
                const d = await r.json();
                if (!r.ok) {
                    toastr.error(d);
                    return;
                }
                ['attendance', 'late', 'early', 'absent', 'overtime'].forEach(k => {
                    const el = document.getElementById(k);
                    if (el && d[k] !== undefined) el.textContent = d[k];
                });
            } catch (e) {
                toastr.error('API Error: ' + e.message);
            }

            try {
                const r = await fetch('/current_month_holiday');
                const d = await r.json();
                if (r.ok) document.getElementById('holiday').textContent = d.holiday ?? '—';
            } catch (e) {}

            try {
                const r = await fetch('/current_month_workin_days');
                const d = await r.json();
                if (r.ok) {
                    document.getElementById('workingdays').textContent = d.currentworkingdays ?? '—';
                    document.getElementById('remainingworkingdays').textContent = d.remainingdays ?? '—';
                }
            } catch (e) {}
        });
    </script>
</body>

</html>