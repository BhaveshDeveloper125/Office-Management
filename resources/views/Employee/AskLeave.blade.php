<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leave • Request</title>
    <x-link />

    <style>
        /* ── CONTENT ── */
        .content { padding: 2.5rem; display: flex; flex-direction: column; gap: 2.5rem; overflow-y: auto; }

        /* ── SECTION LABEL ── */
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
        }

        .glass-card:hover::before { opacity: 1; }

        /* ── STAT CARDS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 0;
        }

        @media (max-width: 1100px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 700px) {
            .stats-grid { grid-template-columns: 1fr; }
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

        .stat-card:hover::before { opacity: 1; }

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

        .stat-card:nth-child(1)::after { background: #FF4C60; }
        .stat-card:nth-child(2)::after { background: #6C63FF; }
        .stat-card:nth-child(3)::after { background: #4ECDC4; }
        .stat-card:nth-child(4)::after { background: #FDCB6E; }
        .stat-card:nth-child(5)::after { background: #F91179; }
        .stat-card:nth-child(6)::after { background: #6C63FF; }
        .stat-card:nth-child(7)::after { background: #4ECDC4; }
        .stat-card:nth-child(8)::after { background: #FF4C60; }

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

        /* ── FORM CARD ── */
        .form-card { padding: 2.5rem 2.8rem; }

        .form-card::after {
            content: '';
            position: absolute;
            top: 1rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 20px;
            background: #6C63FF;
            opacity: 0.5;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.2rem;
        }

        .form-group { display: flex; flex-direction: column; gap: 0.45rem; }
        .form-group.full { grid-column: 1 / -1; }

        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: var(--text-soft);
        }

        .form-input,
        .form-select,
        .form-textarea {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 16px;
            padding: 0.8rem 1.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(6px);
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: rgba(108,99,255,0.45);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 110px;
            border-radius: 20px;
        }

        .form-input::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }

        /* custom select arrow */
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

        .form-actions {
            margin-top: 1.8rem;
            display: flex;
            justify-content: flex-end;
        }

        .submit-btn {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.9rem 3rem;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.4px;
        }

        .submit-btn:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        /* ── TABLE CARD ── */
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

        td.title-cell { color: var(--text-primary); font-weight: 500; }

        td.desc-cell {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: var(--text-soft);
            font-size: 0.85rem;
        }

        /* leave type badge */
        .type-badge {
            display: inline-block;
            border-radius: 20px;
            padding: 0.25rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .type-casual  { background: rgba(108,99,255,0.12); color: #6C63FF; border: 1px solid rgba(108,99,255,0.2); }
        .type-medical { background: rgba(78,205,196,0.12); color: #4ECDC4; border: 1px solid rgba(78,205,196,0.2); }
        .type-other   { background: rgba(253,203,110,0.12); color: #FDCB6E; border: 1px solid rgba(253,203,110,0.2); }

        /* approval status */
        .status-pending  { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--text-soft);  font-size: 0.85rem; font-weight: 500; }
        .status-approved { display: inline-flex; align-items: center; gap: 0.4rem; color: #4ECDC4; font-size: 0.85rem; font-weight: 600; }
        .status-rejected { display: inline-flex; align-items: center; gap: 0.4rem; color: #FF4C60; font-size: 0.85rem; font-weight: 600; }

        .status-pending::before  { content:'●'; font-size:0.6rem; color: var(--text-soft); }
        .status-approved::before { content:'●'; font-size:0.6rem; color:#4ECDC4; }
        .status-rejected::before { content:'●'; font-size:0.6rem; color:#FF4C60; }

        .days-badge {
            font-family: 'Space Grotesk', monospace;
            font-weight: 600;
            color: var(--text-primary);
        }

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
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .page-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            border-color: rgba(108,99,255,0.3);
            color: var(--text-primary);
            box-shadow: 0 8px 20px -8px rgba(108,99,255,0.3);
        }

        .page-btn.current {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            box-shadow: 0 6px 14px rgba(108,99,255,0.4);
        }

        .page-btn:disabled { opacity: 0.3; cursor: not-allowed; }

        /* ── EMPTY STATE ── */
        .empty-row td {
            padding: 3rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.2rem;
            transition: color 0.3s ease;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: auto; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; flex-wrap: wrap; gap: 0.8rem; }
            .form-card { padding: 1.8rem 1.5rem; }
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
            <div class="page-title"><i class="fa-solid fa-calendar-minus" style="color:#2ecc71;"></i> Leave <span>Request</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- STAT CARDS -->
            {{-- <p class="section-title">This Month's Overview</p> --}}
            <div class="stats-grid">
                <a class="stat-card" href="#">
                    <div class="stat-label">Current Leave</div>
                    <div class="stat-value" id="currentLeave">—</div>
                </a>
                <a class="stat-card" href="#">
                    <div class="stat-label">Previous Leave</div>
                    <div class="stat-value" id="previousLeave">—</div>
                </a>
            </div>

            <!-- form card -->
            <div class="section-header">New Leave Request</div>
            <div class="glass-card form-card" id="formCard">
                <form id="leave_form">
                    <div class="form-grid">

                        <!-- title -->
                        <div class="form-group full">
                            <label class="form-label" for="title">Leave Title</label>
                            <input class="form-input" type="text" name="title" id="title" placeholder="e.g. Family vacation, Medical appointment…" required>
                        </div>

                        <!-- duration type -->
                        <div class="form-group">
                            <label class="form-label" for="duration_type">Duration Type</label>
                            <div class="select-wrap">
                                <select class="form-select" name="duration_type" id="duration_type" required>
                                    <option value="half">Half Day</option>
                                    <option value="full">Full Day</option>
                                </select>
                            </div>
                        </div>

                        <!-- leave type -->
                        <div class="form-group">
                            <label class="form-label" for="leave_type">Leave Type</label>
                            <div class="select-wrap">
                                <select class="form-select" name="leave_type" id="leave_type" required>
                                    <option value="casual">Casual</option>
                                    <option value="medical">Medical</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- from -->
                        <div class="form-group">
                            <label class="form-label" for="from">From Date</label>
                            <input class="form-input" type="date" name="from" id="from" required>
                        </div>

                        <!-- to -->
                        <div class="form-group">
                            <label class="form-label" for="to">To Date</label>
                            <input class="form-input" type="date" name="to" id="to" required>
                        </div>

                        <!-- description -->
                        <div class="form-group full">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-textarea" name="description" id="description" placeholder="Briefly describe your reason for leave…" required></textarea>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="submitBtn"><i class="fa-solid fa-paper-plane" style="color:#fff;"></i> Submit Request</button>
                    </div>
                </form>
            </div>

            <!-- leave history table -->
            <div class="section-header">My Leave Requests</div>
            <div class="glass-card table-card" id="tableCard">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Days</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="leaveTable">
                            <tr class="empty-row"><td colspan="7">Loading your leave requests…</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="pagination" id="paginationContainer"></div>
            </div>


            <div class="section-header">Apply for the Pay Leave</div>
            <div class="glass-card table-card" id="">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th>Leave</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="payleaveTable">
                            <tr class="empty-row"><td colspan="7">Loading your leave requests…</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="pagination" id="payLeavePaginationContainer"></div>
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
        localStorage.setItem('theme', theme);
        document.body.classList.toggle('dark', theme === 'dark');
        lightBtn.classList.toggle('active', theme === 'light');
        darkBtn.classList.toggle('active', theme === 'dark');
        if (notify) toastr.info(`${theme} mode`, '', { timeOut: 900 });
    }

    lightBtn.addEventListener('click', () => setTheme('light'));
    darkBtn.addEventListener('click', () => setTheme('dark'));
    setTheme(localStorage.getItem('theme') || 'light', false);

    /* ── MOUSE GLOW on stat cards ── */
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top)  / rect.height) * 100;
            card.style.setProperty('--x', x + '%');
            card.style.setProperty('--y', y + '%');
        });
    });

    /* ── MOUSE GLOW on glass cards ── */
    ['formCard', 'tableCard'].forEach(id => {
        const el = document.getElementById(id);
        el.addEventListener('mousemove', e => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--x', ((e.clientX - r.left) / r.width * 100) + '%');
            el.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── HELPERS ── */
    function approvalBadge(val) {
        if (val === null || val === undefined)    return '<span class="status-pending">Not Reviewed</span>';
        if (val === true  || val === 1)           return '<span class="status-approved">Approved</span>';
        if (val === false || val === 0)           return '<span class="status-rejected">Rejected</span>';
        return '<span class="status-pending">Unknown</span>';
    }

    function typeBadge(type) {
        const cls = { casual: 'type-casual', medical: 'type-medical', other: 'type-other' }[type] || 'type-other';
        return `<span class="type-badge ${cls}">${type}</span>`;
    }

    function calcDays(from, to) {
        return Math.round((new Date(to) - new Date(from)) / (1000*60*60*24)) + 1;
    }

    /* ── LOAD STAT CARDS ── */
    async function loadStats() {
        try {
            const r = await fetch('/current_month_attendace_summary');
            const d = await r.json();
            if (!r.ok) { toastr.error(d); return; }
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
    }

    /* ── SUBMIT LEAVE ── */
    document.getElementById('leave_form').addEventListener('submit', async e => {
        e.preventDefault();

        if (!confirm('Are you sure you want to submit this leave request?')) return;

        const btn = document.getElementById('submitBtn');
        btn.style.transform = 'scale(0.96)';
        setTimeout(() => btn.style.transform = '', 200);

        try {
            const response = await fetch('/create_leave', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: new FormData(e.target),
            });
            const result = await response.json();

            if (!response.ok) {
                toastr.error(result.error);
            } else {
                e.target.reset();
                GetEmpLeaves(1);
                toastr.success(result.success || 'Leave request submitted!');
            }
        } catch(err) {
            toastr.error(String(err));
        }
    });

    /* ── GET LEAVES ── */
    async function GetEmpLeaves(page) {
        page = page || 1;

        const tbody = document.getElementById('leaveTable');
        tbody.innerHTML = '<tr class="empty-row"><td colspan="7">Loading…</td></tr>';

        try {
            const response = await fetch(`/getempleave?page=${page}`);
            const result   = await response.json();

            if (!response.ok) { toastr.error(result.error); return; }

            tbody.innerHTML = '';

            if (!result.leaves.data.length) {
                tbody.innerHTML = '<tr class="empty-row"><td colspan="7">No leave requests found.</td></tr>';
                return;
            }

            result.leaves.data.forEach(i => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="title-cell">${i.title}</td>
                    <td>${i.from}</td>
                    <td>${i.to}</td>
                    <td><span class="days-badge">${calcDays(i.from, i.to)}</span></td>
                    <td>${typeBadge(i.leave_type)}</td>
                    <td class="desc-cell" title="${i.description}">${i.description}</td>
                    <td>${approvalBadge(i.approve)}</td>
                `;
                tbody.appendChild(tr);
            });

            buildPagination(result.leaves);

        } catch(err) {
            toastr.error(String(err));
        }
    }

    function buildPagination(meta) {
        const container = document.getElementById('paginationContainer');
        container.innerHTML = '';

        const make = (label, onClick, disabled, isCurrent) => {
            const btn = document.createElement('button');
            btn.className = 'page-btn' + (isCurrent ? ' current' : '');
            btn.textContent = label;
            btn.disabled = disabled;
            if (!disabled && !isCurrent && onClick) btn.onclick = onClick;
            return btn;
        };

        container.appendChild(make('«', () => GetEmpLeaves(1), false, false));
        container.appendChild(make('‹', () => GetEmpLeaves(meta.current_page - 1), !meta.prev, false));

        let limit = Math.ceil(meta.current_page / 3) * 3;
        if (meta.current_page % 3 === 0) limit += 3;
        if (limit > meta.last_page) limit = meta.last_page;

        for (let i = 1; i <= limit; i++) {
            container.appendChild(make(i, () => GetEmpLeaves(i), false, i === meta.current_page));
        }

        if (limit < meta.last_page) {
            container.appendChild(make('…', null, true, false));
        }

        container.appendChild(make('›', () => GetEmpLeaves(meta.current_page + 1), !meta.next, false));
        container.appendChild(make('»', () => GetEmpLeaves(meta.last_page), false, false));
    }

    async function GetLeaveRecords() {
        try {
            const response = await fetch('/user_leave');
            const result = await response.json();

            if (!response.ok) {
                toastr.error(result.error);
                return;
            }

            // Current leave
            let CurrentLeave = document.querySelector('#currentLeave');
            CurrentLeave.textContent = result.currentLeaves.leaves;

            // Previous leave total
            let previousLeave = document.querySelector('#previousLeave');
            previousLeave.textContent = result.previousYeasrLeave;

            // Previous leave table
            let previousLeaveList = result.previousYeasrLeaveList;
            let payleaveTable = document.querySelector('#payleaveTable');
            payleaveTable.innerHTML = '';

            if (!previousLeaveList.length) {
                payleaveTable.innerHTML = '<tr class="empty-row"><td colspan="3">No previous leave records found.</td></tr>';
                return;
            }

            previousLeaveList.forEach(i => {
                const isApplied = i.pay_request === null; // ✅ null means Applied
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${i.year_extracted}</td>
                    <td style="${isApplied ? 'color: #FF4C60; font-weight: 600;' : ''}">
                        ${i.leaves} ${isApplied ? '<span style="font-size:0.78rem;">(Applied)</span>' : ''}
                    </td>
                    <td>
                        <button class="approve-btn" onclick="applyPayLeave(${i.id})" 
                            ${isApplied ? 'disabled style="opacity:0.4; cursor:not-allowed;"' : ''}>
                            <i class="fa-solid fa-money-bill" style="color:#fff;"></i> 
                            ${isApplied ? 'Already Applied' : 'Apply for Pay'}
                        </button>
                    </td>
                `;
                payleaveTable.appendChild(tr);
            });

        } catch (e) {
            toastr.error("API fetch error: " + e.message);
        }
    }

    async function applyPayLeave(leaveId) {
        if (!confirm('Are you sure you want to apply for pay leave for this year?')) return;

        try {
            const res = await fetch('/apply_pay_on_previous_leave', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: leaveId }),
            });

            const result = await res.json();

            if (res.ok) {
                toastr.success(result.success || 'Pay leave applied successfully!');
                GetLeaveRecords(); // refresh the table
            } else {
                toastr.error(result.error || 'Something went wrong.');
            }

        } catch (e) {
            toastr.error(String(e));
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadStats();
        GetEmpLeaves(1);
        GetLeaveRecords();
    });
</script>
</body>
</html>