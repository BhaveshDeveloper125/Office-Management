<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees • Details</title>
    <x-link />

    <style>
        /* ── CONTENT ── */
        .content {
            padding: 2.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* ── TOOLBAR ROW ── */
        .toolbar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 900px) { .toolbar { grid-template-columns: 1fr; } }

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

        /* ── FORM CARDS ── */
        .form-inner {
            padding: 1.8rem 2rem;
            position: relative;
            z-index: 1;
        }

        .form-label-row {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            color: var(--text-soft);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label-row::before {
            content: '';
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .filter-label-row::before { background: #6C63FF; }
        .search-label-row::before  { background: #FF4C60; }

        .form-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        .form-input, .form-search {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 50px;
            padding: 0.65rem 1.2rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(6px);
        }

        .form-input:focus, .form-search:focus {
            border-color: rgba(108,99,255,0.4);
            box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
        }

        .form-input::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }
        .form-search { min-width: 240px; flex: 1; }

        .btn-primary {
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.65rem 1.8rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-primary:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #6C63FF80;
        }

        .btn-danger {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.65rem 1.8rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-danger:hover {
            transform: scale(1.06) translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 20px 30px -10px #FF4C6080;
        }

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
        }

        .section-header::before {
            content: '';
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #F91179);
        }

        .section-header .count-badge {
            margin-left: auto;
            font-size: 0.75rem;
            background: rgba(108,99,255,0.1);
            color: #6C63FF;
            border: 1px solid rgba(108,99,255,0.18);
            border-radius: 20px;
            padding: 0.2rem 0.75rem;
            font-weight: 600;
        }

        /* ── TABLE CARD ── */
        .table-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            opacity: 0.5;
            z-index: 1;
        }

        .table-card:nth-of-type(1)::after { background: #FF4C60; }
        .table-card:nth-of-type(2)::after { background: #6C63FF; }
        .table-card:nth-of-type(3)::after { background: #4ECDC4; }

        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }

        thead tr {
            background: linear-gradient(135deg, rgba(108,99,255,0.07), rgba(255,76,96,0.04));
            border-bottom: 1px solid var(--card-border);
        }

        th {
            padding: 1rem 1.1rem;
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
            padding: 0.85rem 1.1rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        td.name-cell  { font-weight: 600; color: var(--text-primary); }
        td.email-cell { font-size: 0.78rem; color: var(--text-soft); }

        td.mobile-cell {
            font-family: 'Space Grotesk', monospace;
            font-size: 0.82rem;
        }

        .post-badge {
            display: inline-block;
            background: rgba(108,99,255,0.1);
            color: #6C63FF;
            border: 1px solid rgba(108,99,255,0.2);
            border-radius: 20px;
            padding: 0.2rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-active {
            display: inline-block;
            background: rgba(78,205,196,0.12);
            color: #4ECDC4;
            border: 1px solid rgba(78,205,196,0.25);
            border-radius: 20px;
            padding: 0.2rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .status-ex {
            display: inline-block;
            background: rgba(255,76,96,0.1);
            color: #FF4C60;
            border: 1px solid rgba(255,76,96,0.2);
            border-radius: 20px;
            padding: 0.2rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .action-link {
            display: inline-block;
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border-radius: 20px;
            padding: 0.25rem 0.85rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            margin-right: 0.3rem;
        }

        .action-link:hover {
            transform: scale(1.06) translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 8px 16px -6px #6C63FF80;
        }

        .action-link.danger {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
        }

        .action-link.danger:hover { box-shadow: 0 8px 16px -6px #FF4C6080; }

        /* empty/loading */
        .empty-row td {
            padding: 3rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        /* row entrance */
        @keyframes row-in {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        tbody tr { animation: row-in 0.3s ease both; }

        /* hidden */
        .hidden { display: none !important; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            /* .menu-area handled by common.css */
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
        }

        @media (max-width: 600px) {
            .header-area { padding: 1rem 1.2rem; }
            .form-row { flex-direction: column; align-items: stretch; }
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
            <div class="page-title"><i class="fa-solid fa-users" style="color:#FDCB6E;"></i> Employee <span>Details</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- toolbar: filter + search -->
            <div class="toolbar">

                <!-- filter by joining date -->
                <div class="glass-card" id="filterCard">
                    <div class="form-inner">
                        <div class="form-label-row filter-label-row">Filter by Joining Date</div>
                        <form id="filter">
                            <div class="form-row">
                                <input class="form-input" type="date" name="from" id="from">
                                <input class="form-input" type="date" name="to" id="to">
                                <button type="submit" class="btn-primary" id="filterBtn"><i class="fa-solid fa-magnifying-glass" style="color:#fff;"></i> Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- search by name -->
                <div class="glass-card" id="searchCard">
                    <div class="form-inner">
                        <div class="form-label-row search-label-row">Search Employee</div>
                        <form id="SearchForm">
                            <div class="form-row">
                                <input class="form-search" type="search" name="search" id="search" placeholder="Search by employee name…">
                                <button type="submit" class="btn-danger" id="searchBtn">🔎 Search</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- search results -->
            <div id="searchSection" class="hidden">
                <div class="section-header">
                    Search Results
                    <span class="count-badge" id="searchCount">0 found</span>
                </div>
                <div class="glass-card table-card" id="searchTableCard" style="margin-top:1rem;">
                    <div class="table-wrap">
                        <table>
                            <thead><tr>
                                <th>Name</th><th>Email</th><th>Post</th><th>Mobile</th>
                                <th>Address</th><th>Qualification</th><th>Experience</th>
                                <th>Joining</th><th>From</th><th>To</th><th>Status</th><th>Action</th>
                            </tr></thead>
                            <tbody id="EmpSearch"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- filter results -->
            <div id="filterSection" class="hidden">
                <div class="section-header">
                    Filtered Results
                    <span class="count-badge" id="filterCount">0 found</span>
                </div>
                <div class="glass-card table-card" id="filterTableCard" style="margin-top:1rem;">
                    <div class="table-wrap">
                        <table>
                            <thead><tr>
                                <th>Name</th><th>Email</th><th>Post</th><th>Mobile</th>
                                <th>Address</th><th>Qualification</th><th>Experience</th>
                                <th>Joining</th><th>From</th><th>To</th><th>Status</th><th>Action</th>
                            </tr></thead>
                            <tbody id="filter_emp_details"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- all employees -->
            <div class="section-header">
                All Employees
                <span class="count-badge" id="allCount">loading…</span>
            </div>
            <div class="glass-card table-card" id="allTableCard">
                <div class="table-wrap">
                    <table>
                        <thead><tr>
                            <th>Name</th><th>Email</th><th>Post</th><th>Mobile</th>
                            <th>Address</th><th>Qualification</th><th>Experience</th>
                            <th>Joining</th><th>From</th><th>To</th><th>Status</th>
                            <th>Action</th><th>Password</th>
                        </tr></thead>
                        <tbody id="emp_details">
                            <tr class="empty-row"><td colspan="13">Loading employees…</td></tr>
                        </tbody>
                    </table>
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

    /* ── MOUSE GLOW ── */
    function attachGlow(el) {
        if (!el) return;
        el.addEventListener('mousemove', e => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            el.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    }

    ['filterCard','searchCard','searchTableCard','filterTableCard','allTableCard'].forEach(id => {
        attachGlow(document.getElementById(id));
    });

    /* ── BUTTON CLICK FEEDBACK ── */
    ['filterBtn','searchBtn'].forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.addEventListener('click', () => {
            btn.style.transform = 'scale(0.96)';
            setTimeout(() => btn.style.transform = '', 200);
        });
    });

    /* ── ROW BUILDER ── */
    function buildRow(i, includePasswordCol = false) {
        const statusBadge = i.working
            ? '<span class="status-active">Employee</span>'
            : '<span class="status-ex">Ex-Employee</span>';

        const actionCol = `<a class="action-link" href="/edit_employee/${i.id}" target="_blank">✏️ Edit</a>`;
        const pwCol = includePasswordCol
            ? `<td><a class="action-link danger" href="/edit_password/${i.id}" target="_blank"><i class="fa-solid fa-key"></i> Change</a></td>`
            : '';

        return `
            <td class="name-cell">${i.name}</td>
            <td class="email-cell">${i.email}</td>
            <td><span class="post-badge">${i.post}</span></td>
            <td class="mobile-cell">${i.mobile}</td>
            <td>${i.address}</td>
            <td>${i.qualification}</td>
            <td>${i.experience}</td>
            <td>${i.joining}</td>
            <td>${i.working_from}</td>
            <td>${i.working_to}</td>
            <td>${statusBadge}</td>
            <td>${actionCol}</td>
            ${pwCol}
        `;
    }

    function populateTable(tbodyId, data, includePasswordCol = false, countId = null) {
        const tbody = document.getElementById(tbodyId);
        tbody.innerHTML = '';

        if (countId) {
            document.getElementById(countId).textContent =
                `${data.length} found`;
        }

        if (!data.length) {
            const cols = includePasswordCol ? 13 : 12;
            tbody.innerHTML = `<tr class="empty-row"><td colspan="${cols}">No employees found.</td></tr>`;
            return;
        }

        data.forEach((i, idx) => {
            const tr = document.createElement('tr');
            tr.style.animationDelay = `${idx * 35}ms`;
            tr.innerHTML = buildRow(i, includePasswordCol);
            tbody.appendChild(tr);
        });
    }

    /* ── SEARCH ── */
    document.getElementById('SearchForm').addEventListener('submit', async e => {
        e.preventDefault();
        try {
            const response = await fetch('/search_employee', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: new FormData(e.target),
            });
            const result = await response.json();

            if (!response.ok) { toastr.error(result.error); return; }

            const data = result.EmpDetails?.data || result.EmpDetails || [];

            if (!data.length) {
                toastr.error('No employees found matching that search.');
                document.getElementById('searchSection').classList.add('hidden');
                return;
            }

            document.getElementById('searchSection').classList.remove('hidden');
            populateTable('EmpSearch', data, false, 'searchCount');
            toastr.success(`Found ${data.length} employee(s)`);

        } catch (err) { toastr.error(String(err)); }
    });

    /* ── FILTER ── */
    document.getElementById('filter').addEventListener('submit', async e => {
        e.preventDefault();
        try {
            const response = await fetch('/filter_employee', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: new FormData(e.target),
            });
            const result = await response.json();

            if (!response.ok) { toastr.error(result.error); return; }

            const data = result.EmpDetails?.data || [];
            document.getElementById('filterSection').classList.remove('hidden');
            populateTable('filter_emp_details', data, false, 'filterCount');
            toastr.success(`Filtered: ${data.length} employee(s)`);

        } catch (err) { toastr.error(String(err)); }
    });

    /* ── ALL EMPLOYEES ── */
    async function EmployeeList() {
        try {
            const response = await fetch('/emp_list');
            const result   = await response.json();

            if (!response.ok) { toastr.error(result.error || 'Failed to load employees'); return; }

            const data = result.EmpDetails?.data || [];
            document.getElementById('allCount').textContent = `${data.length} total`;
            populateTable('emp_details', data, true);

        } catch (err) {
            toastr.error(String(err));
        }
    }

    document.addEventListener('DOMContentLoaded', EmployeeList);
</script>
</body>
</html>