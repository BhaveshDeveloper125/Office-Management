<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance • Daily</title>
    <x-link />

    <style>
        /* ── CONTENT ── */
        .content { padding: 2.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1.5rem; }

        /* section label */
        .section-header {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-soft);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0 0.5rem;
        }

        .section-header::before {
            content: '';
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #F91179);
        }

        /* live record count */
        .record-count {
            margin-left: auto;
            font-size: 0.78rem;
            font-family: 'Space Grotesk', monospace;
            background: rgba(108,99,255,0.1);
            color: #6C63FF;
            border: 1px solid rgba(108,99,255,0.18);
            border-radius: 20px;
            padding: 0.2rem 0.8rem;
            font-weight: 600;
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
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.13), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .table-card:hover::before { opacity: 1; }

        /* accent dot */
        .table-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #6C63FF;
            opacity: 0.5;
            z-index: 1;
        }

        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }

        thead tr {
            background: linear-gradient(135deg, rgba(108,99,255,0.07), rgba(255,76,96,0.04));
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

        /* cell variants */
        td.name-cell {
            font-weight: 600;
            color: var(--text-primary);
        }

        td.email-cell {
            font-size: 0.83rem;
            color: var(--text-soft);
        }

        td.mobile-cell {
            font-family: 'Space Grotesk', monospace;
            font-size: 0.85rem;
        }

        td.post-cell {
            display: table-cell;
        }

        .post-badge {
            display: inline-block;
            background: rgba(108,99,255,0.1);
            color: #6C63FF;
            border: 1px solid rgba(108,99,255,0.2);
            border-radius: 20px;
            padding: 0.22rem 0.85rem;
            font-size: 0.76rem;
            font-weight: 600;
            text-transform: capitalize;
            white-space: nowrap;
        }

        td.time-cell {
            font-family: 'Space Grotesk', monospace;
            font-size: 0.88rem;
            font-weight: 500;
        }

        td.checkin-cell  { color: #4ECDC4; }
        td.checkout-cell { color: #FDCB6E; }

        .no-checkout {
            color: var(--text-soft);
            font-style: italic;
            font-size: 0.82rem;
        }

        /* ── EMPTY / LOADING ── */
        .empty-row td {
            padding: 3.5rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        /* row entrance animation */
        @keyframes row-in {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        tbody tr { animation: row-in 0.3s ease both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            /* .menu-area handled by common.css */
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
            .date-pill { display: none; }
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
            <div class="page-title"><i class="fa-solid fa-calendar-days" style="color:#4ECDC4;"></i> Daily <span>Attendance</span></div>
            <div class="header-right">
                <div class="date-pill" id="todayDate">—</div>
                <div class="theme-toggle">
                    <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                    <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
                </div>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <div class="section-header">
                Today's Records
                <span class="record-count" id="recordCount">— records</span>
            </div>

            <div class="table-card" id="tableCard">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Post</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTableBody">
                            <tr class="empty-row"><td colspan="6">Loading today's attendance…</td></tr>
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

    /* ── DATE PILL ── */
    document.getElementById('todayDate').textContent =
        new Date().toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

    /* ── MOUSE GLOW ── */
    const tableCard = document.getElementById('tableCard');
    tableCard.addEventListener('mousemove', e => {
        const r = tableCard.getBoundingClientRect();
        tableCard.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
        tableCard.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
    });

    /* ── FORMAT TIME ── */
    function fmtTime(val) {
        if (!val) return '<span class="no-checkout">Not checked out</span>';
        try {
            return new Date(val).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        } catch {
            return val;
        }
    }

    /* ── FETCH ATTENDANCE ── */
    async function fetchAttendanceData() {
        const tbody = document.getElementById('attendanceTableBody');

        try {
            const response = await fetch('/admin/daily_attendance');
            const result   = await response.json();

            if (!response.ok) {
                toastr.error(result.error || 'Failed to load attendance');
                tbody.innerHTML = '<tr class="empty-row"><td colspan="6">Failed to load data.</td></tr>';
                return;
            }

            const data = result.dailyAttendance.data || [];
            tbody.innerHTML = '';

            document.getElementById('recordCount').textContent =
                `${data.length} record${data.length !== 1 ? 's' : ''}`;

            if (!data.length) {
                tbody.innerHTML = '<tr class="empty-row"><td colspan="6">No attendance records for today.</td></tr>';
                return;
            }

            data.forEach((i, idx) => {
                const tr = document.createElement('tr');
                tr.style.animationDelay = `${idx * 40}ms`;
                tr.innerHTML = `
                    <td class="name-cell">${i.user.name}</td>
                    <td class="email-cell">${i.user.email}</td>
                    <td class="mobile-cell">${i.user.mobile}</td>
                    <td class="post-cell"><span class="post-badge">${i.user.post}</span></td>
                    <td class="time-cell checkin-cell">${fmtTime(i.checkin)}</td>
                    <td class="time-cell checkout-cell">${fmtTime(i.checkout)}</td>
                `;
                tbody.appendChild(tr);
            });

        } catch (err) {
            console.error(err);
            toastr.error('Error fetching attendance data');
            tbody.innerHTML = '<tr class="empty-row"><td colspan="6">Something went wrong.</td></tr>';
        }
    }

    fetchAttendanceData();
</script>
</body>
</html>