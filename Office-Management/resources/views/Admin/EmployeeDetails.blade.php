<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees • Details</title>
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
            --input-bg:          rgba(255,255,255,0.65);
            --input-border:      rgba(200,205,220,0.7);
            --row-hover:         rgba(108,99,255,0.04);
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
            --row-hover:         rgba(108,99,255,0.08);
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
            flex-wrap: wrap;
            gap: 1rem;
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
            .menu-area { width: 80px; }
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
            <div class="page-title">👥 Employee <span>Details</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light">☀️ light</button>
                <button class="theme-option" data-theme="dark">🌙 dark</button>
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
                                <button type="submit" class="btn-primary" id="filterBtn">🔍 Filter</button>
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
            ? `<td><a class="action-link danger" href="/edit_password/${i.id}" target="_blank">🔑 Change</a></td>`
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