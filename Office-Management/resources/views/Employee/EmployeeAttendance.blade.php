<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance • History</title>
    <x-link />

    <style>
        /* ── CONTENT AREA ── */
        .content { padding: 2.5rem; display: flex; flex-direction: column; gap: 2rem; overflow-y: auto; }

        /* ── FILTER CARD ── */
        .filter-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            padding: 2rem 2.5rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative;
            overflow: hidden;
        }

        .filter-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.12), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
        }

        .filter-card:hover::before { opacity: 1; }

        .filter-card::after {
            content: '';
            position: absolute;
            top: 1rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 20px;
            background: #6C63FF;
            opacity: 0.5;
        }

        .filter-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 500;
            color: var(--text-soft);
            margin-bottom: 1.2rem;
        }

        .filter-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.95rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
        }

        .filter-input:focus {
            border-color: #6C63FF60;
            box-shadow: 0 0 0 3px rgba(108,99,255,0.12);
        }

        /* date picker icon color fix */
        .filter-input::-webkit-calendar-picker-indicator { opacity: 0.5; cursor: pointer; }

        .fetch-btn {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .fetch-btn:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        /* ── SECTION HEADERS ── */
        .section-header {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: -0.01em;
            padding: 0 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
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
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
            position: relative;
        }

        .table-card::after {
            content: '';
            position: absolute;
            top: 1rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 20px;
            background: #FF4C60;
            opacity: 0.5;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        thead tr {
            background: linear-gradient(135deg, rgba(108,99,255,0.08), rgba(255,76,96,0.04));
            border-bottom: 1px solid var(--card-border);
        }

        th {
            padding: 1.1rem 1.2rem;
            text-align: center;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: var(--text-soft);
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--card-border);
            transition: background 0.2s ease, transform 0.15s ease;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover {
            background: var(--table-row-hover);
        }

        td {
            padding: 1rem 1.2rem;
            text-align: center;
            color: var(--text-secondary);
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        td:first-child {
            color: var(--text-soft);
            font-size: 0.8rem;
        }

        /* tag badges */
        .tag-late {
            display: inline-block;
            background: rgba(253,203,110,0.15);
            color: #FDCB6E;
            border: 1px solid rgba(253,203,110,0.3);
            border-radius: 20px;
            padding: 0.2rem 0.8rem;
            font-size: 0.78rem;
            font-weight: 600;
            margin: 0.1rem;
        }

        .tag-early {
            display: inline-block;
            background: rgba(255,76,96,0.1);
            color: #FF4C60;
            border: 1px solid rgba(255,76,96,0.25);
            border-radius: 20px;
            padding: 0.2rem 0.8rem;
            font-size: 0.78rem;
            font-weight: 600;
            margin: 0.1rem;
        }

        .hours-low { color: #FF4C60 !important; }
        .hours-ok  { color: #4ECDC4 !important; }

        /* ── PAGINATION ── */
        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.5rem;
            flex-wrap: wrap;
        }

        .page-btn {
            background: var(--card-bg);
            backdrop-filter: blur(8px);
            border: 1px solid var(--card-border);
            border-radius: 50px;
            padding: 0.5rem 1.2rem;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .page-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            border-color: #6C63FF40;
            color: var(--text-primary);
            box-shadow: 0 8px 20px -8px rgba(108,99,255,0.3);
        }

        .page-btn.current {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            box-shadow: 0 6px 14px rgba(108,99,255,0.4);
        }

        .page-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        /* ── EMPTY STATE ── */
        .empty-row td {
            padding: 3rem;
            color: var(--text-soft);
            font-style: italic;
        }

        /* ── HIDDEN ── */
        .hidden { display: none !important; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            /* .menu-area handled by common.css */
            .logo { font-size: 1.2rem; padding-left: 0.5rem; }
            .menu-item span { display: none; }
            .content { padding: 1.5rem; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; flex-wrap: wrap; gap: 1rem; }
            .filter-row { flex-direction: column; align-items: stretch; }
            .fetch-btn { text-align: center; }
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
            <div class="page-title"><i class="fa-solid fa-calendar-days" style="color:#4ECDC4;"></i> Attendance <span>History</span></div>
            <div class="theme-toggle" id="themeToggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- filter card -->
            <div class="filter-card" id="filterCard">
                <div class="filter-label">Filter by date range</div>
                <form id="EmpFilterHistoryForm">
                    <div class="filter-row">
                        <input class="filter-input" type="date" name="from" id="from" required placeholder="From">
                        <input class="filter-input" type="date" name="to" id="to" placeholder="To (optional)">
                        <button type="submit" class="fetch-btn" id="fetchBtn"><i class="fa-solid fa-magnifying-glass"></i> Fetch History</button>
                    </div>
                </form>
            </div>

            <!-- filtered results (hidden until submitted) -->
            <div id="filteredSection" class="hidden">
                <div class="section-header">Filtered Results</div>
                <div class="table-card" style="margin-top:1rem;">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Tag</th>
                                    <th>Worked</th>
                                    <th>Required</th>
                                    <th>Shift From</th>
                                    <th>Shift To</th>
                                </tr>
                            </thead>
                            <tbody id="EmpHistoryFilter"></tbody>
                        </table>
                    </div>
                    <div class="pagination" id="paginationContainer"></div>
                </div>
            </div>

            <!-- current month -->
            <div class="section-header">This Month's Attendance</div>
            <div class="table-card">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Tag</th>
                                <th>Worked</th>
                                <th>Required</th>
                                <th>Shift From</th>
                                <th>Shift To</th>
                            </tr>
                        </thead>
                        <tbody id="EmpHistory">
                            <tr class="empty-row"><td colspan="10">Loading attendance data…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->
</div><!-- /app -->


<script>
    /* ── TOASTR ── */
    toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-bottom-right" };

    /* ── THEME ── */
    const body = document.body;
    const lightBtn = document.querySelector('[data-theme="light"]');
    const darkBtn  = document.querySelector('[data-theme="dark"]');

    function setTheme(theme, notify = true) {
        if (theme === 'dark') {
            body.classList.add('dark');
            lightBtn.classList.remove('active');
            darkBtn.classList.add('active');
        } else {
            body.classList.remove('dark');
            darkBtn.classList.remove('active');
            lightBtn.classList.add('active');
        }
        localStorage.setItem('theme', theme);
        if (notify) toastr.info(`${theme} mode`, '', { timeOut: 900 });
    }

    lightBtn.addEventListener('click', () => setTheme('light'));
    darkBtn.addEventListener('click', () => setTheme('dark'));
    setTheme(localStorage.getItem('theme') || 'light', false);

    /* ── MOUSE GLOW ── */
    document.querySelectorAll('.filter-card, .table-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const r = card.getBoundingClientRect();
            card.style.setProperty('--x', ((e.clientX - r.left) / r.width * 100) + '%');
            card.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── HELPERS ── */
    function buildTag(tagStr) {
        if (!tagStr || tagStr === '-') return '<span style="color:var(--text-soft)">—</span>';
        return tagStr
            .replace(/Late/g,       '<span class="tag-late">Late</span>')
            .replace(/Early leave/g,'<span class="tag-early">Early Leave</span>');
    }

    function fmtHours(hours) {
        return (hours || '0:0:0').split(':').slice(0,2)
            .map((v,i) => `${parseInt(v)} ${i===0?'hr':'min'}`).join(' ');
    }

    function buildRow(i, index, tagStr) {
        const hoursVal = parseInt((i.hours||'0').split(':')[0]);
        const hoursClass = hoursVal < 9 ? 'hours-low' : 'hours-ok';
        return `
            <td>${index}</td>
            <td>${new Date(i.created_at).toLocaleDateString('en-GB')}</td>
            <td>${new Date(i.created_at).toLocaleDateString('en-GB',{weekday:'short'})}</td>
            <td>${new Date(i.checkin).toLocaleTimeString('en-GB')}</td>
            <td>${i.checkout ? new Date(i.checkout).toLocaleTimeString('en-GB') : '—'}</td>
            <td>${buildTag(tagStr)}</td>
            <td class="${hoursClass}">${fmtHours(i.hours)}</td>
            <td>${i.user.hours} hr</td>
            <td>${i.user.working_from}</td>
            <td>${i.user.working_to}</td>
        `;
    }

    /* ── FILTER FORM ── */
    document.querySelector('#EmpFilterHistoryForm').addEventListener('submit', e => {
        e.preventDefault();
        const btn = document.getElementById('fetchBtn');
        btn.style.transform = 'scale(0.96)';
        setTimeout(() => btn.style.transform = '', 200);
        EmpFilterHistoryForm(1, true);
    });

    async function EmpFilterHistoryForm(page, isFormSubmission = false) {
        try {
            const response = await fetch(`/filter_emp_history?page=${page}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: new FormData(document.querySelector('#EmpFilterHistoryForm')),
            });
            const result = await response.json();

            if (!response.ok) { toastr.error(result.error); return; }

            const tbody = document.querySelector('#EmpHistoryFilter');
            tbody.innerHTML = '';
            document.getElementById('filteredSection').classList.remove('hidden');

            result.attendance.data.forEach((i, idx) => {
                let tag = '';
                if (i.checkin > i.user.working_from) tag = 'Late';
                else if (i.checkin < i.user.working_from) tag = 'Early';
                const tr = document.createElement('tr');
                tr.innerHTML = buildRow(i, result.attendance.from + idx, tag);
                tbody.appendChild(tr);
            });

            if (isFormSubmission) toastr.success('History fetched');

            /* pagination */
            buildPagination(result.attendance, page => EmpFilterHistoryForm(page));

        } catch(e) { toastr.error(String(e)); }
    }

    function buildPagination(meta, cb) {
        const container = document.getElementById('paginationContainer');
        container.innerHTML = '';
        if (meta.total <= meta.per_page) return;

        const make = (label, page, disabled, isCurrent) => {
            const btn = document.createElement('button');
            btn.className = 'page-btn' + (isCurrent ? ' current' : '');
            btn.textContent = label;
            btn.disabled = disabled;
            if (!disabled && !isCurrent) btn.onclick = () => cb(page);
            return btn;
        };

        container.appendChild(make('«', 1, false, false));
        container.appendChild(make('‹ Prev', meta.current_page - 1, !meta.prev_page_url, false));

        let start = Math.max(1, meta.current_page - 1);
        let end   = Math.min(start + 2, meta.last_page);
        if (meta.current_page === meta.last_page) { start = Math.max(1, meta.last_page - 2); end = meta.last_page; }

        for (let i = start; i <= end; i++) {
            container.appendChild(make(i, i, false, i === meta.current_page));
        }

        container.appendChild(make('Next ›', meta.current_page + 1, !meta.next_page_url, false));
        container.appendChild(make('»', meta.last_page, false, false));
    }

    /* ── CURRENT MONTH ── */
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('/emp/history');
            const result   = await response.json();

            const tbody = document.querySelector('#EmpHistory');
            tbody.innerHTML = '';

            if (!response.ok) { toastr.error(result.error); return; }

            if (!result.History.length) {
                tbody.innerHTML = '<tr class="empty-row"><td colspan="10">No attendance records this month.</td></tr>';
                return;
            }

            result.History.forEach((i, idx) => {
                let tagStr = '';

                const checkinDate = new Date(i.checkin);
                const checkinMins = checkinDate.getHours() * 60 + checkinDate.getMinutes();
                const [h, m] = i.user.working_from.split(':');
                const workMins = parseInt(h) * 60 + parseInt(m);
                if (checkinMins > workMins) tagStr += 'Late';

                if (i.checkout) {
                    const checkoutDate = new Date(i.checkout);
                    const checkoutMins = checkoutDate.getHours() * 60 + checkoutDate.getMinutes();
                    const [h2, m2] = i.user.working_to.split(':');
                    const workEndMins = parseInt(h2) * 60 + parseInt(m2);
                    if (checkoutMins < workEndMins) tagStr += 'Early leave';
                }

                if (!tagStr) tagStr = '-';

                const tr = document.createElement('tr');
                tr.innerHTML = buildRow(i, idx + 1, tagStr);
                tbody.appendChild(tr);
            });

        } catch(e) { toastr.error(String(e)); }
    });
</script>
</body>
</html>