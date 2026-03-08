<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee • attendance</title>
    <x-link />
    <style id="theme-variables">
        /* CARDS — completely fresh design */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            padding: 2.5rem 2.5rem 1.5rem 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            padding: 2rem 1.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x, 50%) var(--y, 0%),
                    rgba(255, 255, 255, 0.15), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: #FF4C6040;
            box-shadow: 0 40px 70px -20px rgba(255, 76, 96, 0.3), var(--card-shadow);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 500;
            color: var(--text-soft);
            margin-bottom: 0.8rem;
        }

        .stat-value {
            font-family: 'Space Grotesk', monospace;
            font-size: 3.4rem;
            font-weight: 600;
            line-height: 1;
            background: var(--stat-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: transform 0.2s;
        }

        .stat-card:hover .stat-value {
            transform: scale(1.02);
        }

        /* subtle color dots */
        .stat-card::after {
            content: '';
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            width: 10px;
            height: 10px;
            border-radius: 20px;
            background: #FF4C60;
            opacity: 0.5;
            transition: 0.3s;
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

        /* check panel minimal & sleek */
        .check-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2.5rem 2.5rem 2.5rem;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .clock-card {
            background: var(--clock-bg);
            backdrop-filter: var(--card-backdrop);
            border-radius: 80px;
            padding: 0.8rem 2.8rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: background 0.4s;
        }

        .clock-display {
            font-family: 'Space Grotesk', monospace;
            font-size: 3.6rem;
            font-weight: 500;
            letter-spacing: 6px;
            background: linear-gradient(130deg, #FF4C60, #FDCB6E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-group {
            display: flex;
            gap: 1.2rem;
        }

        .action-btn {
            border: none;
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            padding: 1rem 2.8rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            letter-spacing: 0.5px;
        }

        .action-btn.checkin {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
        }

        .action-btn.checkout {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white;
            border: none;
        }

        .action-btn:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        .action-btn.checkout:hover {
            box-shadow: 0 20px 30px -10px #FF4C6080;
        }

        /* glow animation */
        @keyframes soft-pulse {
            0% {
                box-shadow: 0 0 10px rgba(255, 76, 96, 0.1), 0 0 20px rgba(108, 99, 255, 0.1);
            }

            100% {
                box-shadow: 0 0 25px rgba(255, 76, 96, 0.3), 0 0 40px rgba(108, 99, 255, 0.2);
            }
        }

        .glow-pulse {
            animation: soft-pulse 3s infinite alternate;
        }

        /* responsive */
        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .clock-display {
                font-size: 2.5rem;
            }

            .menu-area {
                width: 100px;
            }

            .logo span {
                display: none;
            }
        }

        /* hide duplicate clock */
        #LiveClock2 {
            display: none;
        }
    </style>
</head>

<body class=""> <!-- light default -->
    <div class="app">
        <!-- menu -->
        <x-employee-menu />

        <!-- main -->
        <div class="main">
            <!-- header with toggle -->
            <div class="header-area">
                <div class="greet"><i class="fa-solid fa-star" style="color:#FDCB6E;"></i> welcome back, <span>Alex</span></div>
                <div class="theme-toggle" id="themeToggle">
                    <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                    <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
                </div>
            </div>

            <!-- cards grid -->
            <div class="stats-grid">
                <div class="stat-card" id="card1">
                    <div class="stat-label">attendance</div>
                    <div class="stat-value" id="attendance">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">late</div>
                    <div class="stat-value" id="late">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">early leave</div>
                    <div class="stat-value" id="early">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">absent</div>
                    <div class="stat-value" id="absent">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">overtime</div>
                    <div class="stat-value" id="overtime">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">holiday</div>
                    <div class="stat-value" id="holiday">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">working days</div>
                    <div class="stat-value" id="workingdays">—</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">remaining</div>
                    <div class="stat-value" id="remainingworkingdays">—</div>
                </div>
            </div>

            <!-- clock + actions -->
            <div class="check-panel">
                <div class="clock-card glow-pulse">
                    <span class="clock-display" id="LiveClock">00:00:00</span>
                </div>
                <div class="action-group">
                    <form id="CheckIn">@csrf</form>
                    <form id="CheckOut">@csrf</form>
                    <button type="submit" form="CheckIn" class="action-btn checkin">🚀 check in</button>
                    <button type="submit" form="CheckOut" class="action-btn checkout"><i class="fa-solid fa-right-from-bracket" style="color:#fff;"></i> check out</button>
                </div>
            </div>
            <!-- hidden legacy clock -->
            <div id="LiveClock2"></div>
        </div>
    </div>

    <!-- scripts -->
    <script>
        // toastr setup
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right"
        };

        // ----- THEME TOGGLE (ultra smooth, no lag) -----
        const body = document.body;
        const lightBtn = document.querySelector('[data-theme="light"]');
        const darkBtn = document.querySelector('[data-theme="dark"]');

        function setTheme(theme, notify = true) {
            if (theme === 'dark') {
                body.classList.add('dark');
                lightBtn.classList.remove('active');
                darkBtn.classList.add('active');
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark');
                darkBtn.classList.remove('active');
                lightBtn.classList.add('active');
                localStorage.setItem('theme', 'light');
            }
            // small feedback – only when user explicitly toggles
            if (notify) toastr.info(`${theme} mode`, '', {
                timeOut: 1000
            });
        }

        lightBtn.addEventListener('click', () => setTheme('light'));
        darkBtn.addEventListener('click', () => setTheme('dark'));

        // load saved theme (default light) – no toast on page load
        const saved = localStorage.getItem('theme') || 'light';
        setTheme(saved, false);

        // ----- LIVE CLOCK (silky) -----
        function updateClock() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('LiveClock').textContent = timeStr;
            document.getElementById('LiveClock2') && (document.getElementById('LiveClock2').textContent = timeStr);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // ----- MOCK CARDS (smooth data appear) -----
        function loadCards() {
            setTimeout(() => {
                document.getElementById('attendance').textContent = '24';
                document.getElementById('late').textContent = '2';
                document.getElementById('early').textContent = '1';
                document.getElementById('absent').textContent = '0';
                document.getElementById('overtime').textContent = '6h';
                document.getElementById('holiday').textContent = '3';
                document.getElementById('workingdays').textContent = '22';
                const today = new Date().getDate();
                const remaining = 22 - today > 0 ? 22 - today : 0;
                document.getElementById('remainingworkingdays').textContent = remaining;
            }, 300);
        }
        document.addEventListener('DOMContentLoaded', loadCards);

        // ----- CHECK IN/OUT (smooth simulation) -----
        document.getElementById('CheckIn').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.querySelector('button[form="CheckIn"]');
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => btn.style.transform = '', 200);
            await new Promise(r => setTimeout(r, 500));
            toastr.success(`Checked in at ${document.getElementById('LiveClock').textContent}`);
        });

        document.getElementById('CheckOut').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.querySelector('button[form="CheckOut"]');
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => btn.style.transform = '', 200);
            await new Promise(r => setTimeout(r, 500));
            toastr.success(`Checked out at ${document.getElementById('LiveClock').textContent}`);
        });

        // optional parallax effect on cards (mouse move)
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                card.style.setProperty('--x', x + '%');
                card.style.setProperty('--y', y + '%');
            });
        });
    </script>
</body>

</html>
