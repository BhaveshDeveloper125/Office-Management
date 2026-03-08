<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees • Search</title>
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

        /* ── SEARCH CARD ── */
        .search-card {
            background: var(--card-bg);
            backdrop-filter: var(--card-backdrop);
            border: 1px solid var(--card-border);
            border-radius: 36px;
            box-shadow: var(--card-shadow);
            padding: 2rem 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.2,0.9,0.4,1);
        }

        .search-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.13), transparent 50%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 0;
        }

        .search-card:hover::before { opacity: 1; }

        .search-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #FF4C60;
            opacity: 0.5;
            z-index: 1;
        }

        .search-inner { position: relative; z-index: 1; }

        .search-label {
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

        .search-label::before {
            content: '';
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF4C60, #F91179);
        }

        .search-row {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 50px;
            padding: 0.85rem 1.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            color: var(--text-primary);
            outline: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(6px);
        }

        .search-input::placeholder { color: var(--text-soft); }

        .search-input:focus {
            border-color: rgba(255,76,96,0.4);
            box-shadow: 0 0 0 3px rgba(255,76,96,0.1);
        }

        .search-btn {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.85rem 2.4rem;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            letter-spacing: 0.3px;
        }

        .search-btn:hover {
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
            background: linear-gradient(135deg, #6C63FF, #4a43d9);
        }

        .count-badge {
            margin-left: auto;
            font-size: 0.75rem;
            background: rgba(108,99,255,0.1);
            color: #6C63FF;
            border: 1px solid rgba(108,99,255,0.2);
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
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #6C63FF;
            opacity: 0.5;
            z-index: 1;
        }

        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }

        thead tr {
            background: linear-gradient(135deg, rgba(108,99,255,0.07), rgba(255,76,96,0.04));
            border-bottom: 1px solid var(--card-border);
        }

        th {
            padding: 1.1rem 1.2rem;
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
            padding: 0.9rem 1.2rem;
            color: var(--text-secondary);
            font-size: 0.88rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        td.name-cell  { font-weight: 600; color: var(--text-primary); }
        td.email-cell { font-size: 0.8rem; color: var(--text-soft); }
        td.mono-cell  { font-family: 'Space Grotesk', monospace; font-size: 0.83rem; }

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

        .action-link {
            display: inline-block;
            background: linear-gradient(145deg, #6C63FF, #4a43d9);
            color: white;
            border-radius: 20px;
            padding: 0.25rem 0.9rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            margin-right: 0.3rem;
            white-space: nowrap;
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

        /* ── EMPTY / IDLE STATES ── */
        .empty-row td {
            padding: 4rem;
            text-align: center;
            color: var(--text-soft);
        }

        .idle-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.8rem;
            padding: 4rem 2rem;
        }

        .idle-icon { font-size: 3rem; opacity: 0.4; }

        .idle-text {
            font-size: 0.95rem;
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
            .search-row { flex-direction: column; align-items: stretch; }
            .search-card { padding: 1.5rem; }
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
            <div class="page-title">🔎 Employee <span>Search</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- search bar card -->
            <div class="search-card" id="searchCard">
                <div class="search-inner">
                    <div class="search-label">Search by name or email</div>
                    <form id="searchform">
                        <div class="search-row">
                            <input
                                class="search-input"
                                type="text"
                                name="search"
                                id="searchInput"
                                placeholder="e.g. John Doe or john@company.com"
                                required
                                autocomplete="off"
                            >
                            <button type="submit" class="search-btn" id="searchBtn"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- results section -->
            <div id="resultsSection">
                <div class="section-header">
                    <span id="sectionLabel">Results</span>
                    <span class="count-badge hidden" id="countBadge">0 found</span>
                </div>

                <div class="table-card" id="tableCard" style="margin-top:1rem;">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Post</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Qualification</th>
                                    <th>Experience</th>
                                    <th>Joining</th>
                                    <th>Shift From</th>
                                    <th>Shift To</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                <tr>
                                    <td colspan="11">
                                        <div class="idle-state">
                                            <div class="idle-icon"><i class="fa-solid fa-magnifying-glass" style="color:#6C63FF;font-size:2rem;"></i></div>
                                            <div class="idle-text">Enter a name or email above to search employees</div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

    /* ── MOUSE GLOW ── */
    ['searchCard', 'tableCard'].forEach(id => {
        const el = document.getElementById(id);
        el.addEventListener('mousemove', e => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            el.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── SEARCH BTN FEEDBACK ── */
    document.getElementById('searchBtn').addEventListener('click', function () {
        this.style.transform = 'scale(0.96)';
        setTimeout(() => this.style.transform = '', 200);
    });

    /* ── SEARCH ── */
    document.getElementById('searchform').addEventListener('submit', searchEmployee);

    async function searchEmployee(e) {
        e.preventDefault();
        const query  = document.getElementById('searchInput').value.trim();
        const tbody  = document.getElementById('searchResults');
        const badge  = document.getElementById('countBadge');
        const label  = document.getElementById('sectionLabel');

        tbody.innerHTML = '<tr class="empty-row"><td colspan="11">Searching…</td></tr>';
        badge.classList.add('hidden');

        try {
            const response = await fetch('/search_employee', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ search: query }),
            });

            const data = await response.json();

            if (!response.ok) {
                toastr.error(data.error || 'Search failed');
                tbody.innerHTML = '<tr class="empty-row"><td colspan="11">Something went wrong.</td></tr>';
                return;
            }

            const employees = data.EmpDetails?.data || data.EmpDetails || [];
            tbody.innerHTML = '';

            label.textContent = `Results for "${query}"`;
            badge.textContent  = `${employees.length} found`;
            badge.classList.remove('hidden');

            if (!employees.length) {
                tbody.innerHTML = `<tr><td colspan="11"><div class="idle-state"><div class="idle-icon">😶</div><div class="idle-text">No employees matched your search.</div></div></td></tr>`;
                toastr.warning('No employees found for that query.');
                return;
            }

            employees.forEach((i, idx) => {
                const tr = document.createElement('tr');
                tr.style.animationDelay = `${idx * 40}ms`;
                tr.innerHTML = `
                    <td class="name-cell">${i.name}</td>
                    <td class="email-cell">${i.email}</td>
                    <td><span class="post-badge">${i.post}</span></td>
                    <td class="mono-cell">${i.mobile}</td>
                    <td>${i.address}</td>
                    <td>${i.qualification}</td>
                    <td>${i.experience} yr${i.experience != 1 ? 's' : ''}</td>
                    <td class="mono-cell">${i.joining_date ?? i.joining ?? '—'}</td>
                    <td class="mono-cell">${i.working_from}</td>
                    <td class="mono-cell">${i.working_to}</td>
                    <td>
                        <a class="action-link" href="/edit_employee/${i.id}" target="_blank">✏️ Edit</a>
                        <a class="action-link danger" href="/edit_password/${i.id}" target="_blank"><i class="fa-solid fa-key"></i> Password</a>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            toastr.success(`Found ${employees.length} employee(s)`);

        } catch (err) {
            console.error(err);
            toastr.error('Error: ' + err.message);
            tbody.innerHTML = '<tr class="empty-row"><td colspan="11">Request failed.</td></tr>';
        }
    }
</script>
</body>
</html>