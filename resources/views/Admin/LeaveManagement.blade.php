<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leaves • Management</title>
    <x-link />

    <style>
        /* ── CONTENT ── */
        .content {
            padding: 2.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        /* ── SECTION HEADER ── */
        .section-header {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1rem; font-weight: 600;
            color: var(--text-soft);
            display: flex; align-items: center;
            gap: 0.7rem; margin-bottom: 1rem;
            padding: 0 0.5rem;
        }

        .section-header::before {
            content: '';
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
        }

        .section-header.pending::before  { background: linear-gradient(135deg, #FDCB6E, #e0a940); }
        .section-header.approved::before { background: linear-gradient(135deg, #4ECDC4, #2fb8af); }
        .section-header.rejected::before { background: linear-gradient(135deg, #FF4C60, #F91179); }

        .count-badge {
            margin-left: auto;
            font-size: 0.73rem;
            border-radius: 20px;
            padding: 0.2rem 0.75rem;
            font-weight: 600;
        }

        .count-badge.pending  { background: rgba(253,203,110,0.12); color: #FDCB6E; border: 1px solid rgba(253,203,110,0.25); }
        .count-badge.approved { background: rgba(78,205,196,0.12);  color: #4ECDC4; border: 1px solid rgba(78,205,196,0.25); }
        .count-badge.rejected { background: rgba(255,76,96,0.1);    color: #FF4C60; border: 1px solid rgba(255,76,96,0.22); }

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
            position: absolute; inset: 0;
            background: radial-gradient(800px circle at var(--x,50%) var(--y,0%), rgba(255,255,255,0.13), transparent 50%);
            opacity: 0; transition: opacity 0.5s;
            pointer-events: none; z-index: 0;
        }

        .table-card:hover::before { opacity: 1; }

        .table-card::after {
            content: '';
            position: absolute;
            top: 1.2rem; right: 1.5rem;
            width: 10px; height: 10px;
            border-radius: 50%; opacity: 0.5; z-index: 1;
        }

        .table-card.pending-card::after  { background: #FDCB6E; }
        .table-card.approved-card::after { background: #4ECDC4; }
        .table-card.rejected-card::after { background: #FF4C60; }

        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.87rem; }

        thead tr {
            border-bottom: 1px solid var(--card-border);
        }

        .pending-card thead tr  { background: linear-gradient(135deg, rgba(253,203,110,0.07), rgba(253,203,110,0.03)); }
        .approved-card thead tr { background: linear-gradient(135deg, rgba(78,205,196,0.07), rgba(78,205,196,0.03)); }
        .rejected-card thead tr { background: linear-gradient(135deg, rgba(255,76,96,0.07), rgba(255,76,96,0.03)); }

        th {
            padding: 1rem 1.1rem;
            text-align: left;
            font-size: 0.67rem;
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
            vertical-align: middle;
            white-space: nowrap;
        }

        td.name-cell  { font-weight: 600; color: var(--text-primary); }
        td.email-cell { font-size: 0.78rem; color: var(--text-soft); }
        td.mono-cell  { font-family: 'Space Grotesk', monospace; font-size: 0.82rem; }

        /* badges */
        .post-badge {
            display: inline-block;
            background: rgba(108,99,255,0.1); color: #6C63FF;
            border: 1px solid rgba(108,99,255,0.2);
            border-radius: 20px; padding: 0.18rem 0.7rem;
            font-size: 0.7rem; font-weight: 600;
            text-transform: capitalize;
        }

        .leave-type-badge {
            display: inline-block;
            border-radius: 20px; padding: 0.18rem 0.7rem;
            font-size: 0.7rem; font-weight: 600;
            text-transform: capitalize;
        }

        .lt-casual  { background: rgba(108,99,255,0.1); color: #6C63FF; border: 1px solid rgba(108,99,255,0.2); }
        .lt-medical { background: rgba(78,205,196,0.1); color: #4ECDC4; border: 1px solid rgba(78,205,196,0.22); }
        .lt-other   { background: rgba(253,203,110,0.1); color: #FDCB6E; border: 1px solid rgba(253,203,110,0.22); }

        .duration-badge {
            display: inline-block;
            background: rgba(249,17,121,0.08); color: #F91179;
            border: 1px solid rgba(249,17,121,0.18);
            border-radius: 20px; padding: 0.18rem 0.7rem;
            font-size: 0.7rem; font-weight: 600;
            text-transform: capitalize;
        }

        .days-num {
            font-family: 'Space Grotesk', monospace;
            font-weight: 700; font-size: 0.95rem;
            color: var(--text-primary);
        }

        /* action buttons in table */
        .approve-btn {
            background: linear-gradient(145deg, #4ECDC4, #2fb8af);
            color: white; border: none;
            border-radius: 20px; padding: 0.28rem 0.9rem;
            font-size: 0.72rem; font-weight: 600;
            cursor: pointer; transition: all 0.25s ease;
            margin-right: 0.35rem; white-space: nowrap;
        }

        .approve-btn:hover {
            transform: scale(1.08) translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 8px 16px -6px rgba(78,205,196,0.5);
        }

        .reject-btn {
            background: linear-gradient(145deg, #FF4C60, #d43f52);
            color: white; border: none;
            border-radius: 20px; padding: 0.28rem 0.9rem;
            font-size: 0.72rem; font-weight: 600;
            cursor: pointer; transition: all 0.25s ease;
            white-space: nowrap;
        }

        .reject-btn:hover {
            transform: scale(1.08) translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 8px 16px -6px #FF4C6080;
        }

        /* empty state */
        .empty-row td {
            padding: 2.5rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        /* row entrance */
        @keyframes row-in {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        tbody tr { animation: row-in 0.28s ease both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            /* .menu-area handled by common.css */
            .logo { font-size: 1.2rem; padding-left: 0.4rem; }
            .content { padding: 1.5rem; }
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
            <div class="page-title"><i class="fa-solid fa-calendar-minus" style="color:#2ecc71;"></i> Leave <span>Management</span></div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <!-- ── PENDING ── -->
            <div>
                <div class="section-header pending">
                    Pending Leaves
                    <span class="count-badge pending" id="pendingCount">loading…</span>
                </div>
                <div class="table-card pending-card" id="pendingCard">
                    <div class="table-wrap">
                        <table>
                            <thead><tr>
                                <th>Name</th><th>Email</th><th>Post</th><th>Mobile</th>
                                <th>Title</th><th>Duration</th><th>Type</th>
                                <th>Days</th><th>From</th><th>To</th><th>Actions</th>
                            </tr></thead>
                            <tbody id="pendingLeaves">
                                <tr class="empty-row"><td colspan="11">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ── APPROVED ── -->
            <div>
                <div class="section-header approved">
                    Approved Leaves
                    <span class="count-badge approved" id="approvedCount">loading…</span>
                </div>
                <div class="table-card approved-card" id="approvedCard">
                    <div class="table-wrap">
                        <table>
                            <thead><tr>
                                <th>Name</th><th>Email</th><th>Post</th><th>Mobile</th>
                                <th>Title</th><th>Duration</th><th>Type</th>
                                <th>Days</th><th>From</th><th>To</th>
                            </tr></thead>
                            <tbody id="approvedLeaves">
                                <tr class="empty-row"><td colspan="10">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ── REJECTED ── -->
            <div>
                <div class="section-header rejected">
                    Rejected Leaves
                    <span class="count-badge rejected" id="rejectedCount">loading…</span>
                </div>
                <div class="table-card rejected-card" id="rejectedCard">
                    <div class="table-wrap">
                        <table>
                            <thead><tr>
                                <th>Name</th><th>Email</th><th>Post</th><th>Mobile</th>
                                <th>Title</th><th>Duration</th><th>Type</th>
                                <th>Days</th><th>From</th><th>To</th>
                            </tr></thead>
                            <tbody id="rejectedLeaves">
                                <tr class="empty-row"><td colspan="10">Loading…</td></tr>
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
    ['pendingCard','approvedCard','rejectedCard'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('mousemove', e => {
            const r = el.getBoundingClientRect();
            el.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            el.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    });

    /* ── HELPERS ── */
    const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function leaveTypeBadge(type) {
        const cls = { casual: 'lt-casual', medical: 'lt-medical', other: 'lt-other' }[type] || 'lt-other';
        return `<span class="leave-type-badge ${cls}">${type}</span>`;
    }

    function buildRow(i, includeActions = false) {
        const actionCol = includeActions ? `
            <td>
                <button class="approve-btn" onclick="approveLeave(${i.id})"><i class="fa-solid fa-check" style="color:#2ecc71;"></i> Approve</button>
                <button class="reject-btn"  onclick="rejectLeave(${i.id})">✗ Reject</button>
            </td>` : '';

        return `
            <td class="name-cell">${i.user.name}</td>
            <td class="email-cell">${i.user.email}</td>
            <td><span class="post-badge">${i.user.post}</span></td>
            <td class="mono-cell">${i.user.mobile}</td>
            <td style="font-weight:500;color:var(--text-primary)">${i.title}</td>
            <td><span class="duration-badge">${i.duration_type}</span></td>
            <td>${leaveTypeBadge(i.leave_type)}</td>
            <td><span class="days-num">${i.total_days ?? '—'}</span></td>
            <td class="mono-cell">${i.from}</td>
            <td class="mono-cell">${i.to}</td>
            ${actionCol}
        `;
    }

    function populate(tbodyId, data, countId, countClass, includeActions = false, emptyCols = 10) {
        const tbody = document.getElementById(tbodyId);
        tbody.innerHTML = '';
        document.getElementById(countId).textContent = `${data.length} leave${data.length !== 1 ? 's' : ''}`;

        if (!data.length) {
            tbody.innerHTML = `<tr class="empty-row"><td colspan="${emptyCols}">No records found.</td></tr>`;
            return;
        }

        data.forEach((i, idx) => {
            const tr = document.createElement('tr');
            tr.style.animationDelay = `${idx * 35}ms`;
            tr.innerHTML = buildRow(i, includeActions);
            tbody.appendChild(tr);
        });
    }

    /* ── FETCH PENDING ── */
    async function GetPendingLeaves() {
        try {
            const res    = await fetch('/admin/leaves/pending');
            const result = await res.json();
            if (res.ok) populate('pendingLeaves', result.pending.data, 'pendingCount', 'pending', true, 11);
            else toastr.error(result.error || 'Failed to load pending leaves');
        } catch (e) { toastr.error('Error fetching pending leaves'); }
    }

    /* ── FETCH APPROVED ── */
    async function GetApprovedLeaves() {
        try {
            const res    = await fetch('/admin/leaves/approved');
            const result = await res.json();
            if (res.ok) populate('approvedLeaves', result.approved.data, 'approvedCount', 'approved', false, 10);
            else toastr.error(result.error || 'Failed to load approved leaves');
        } catch (e) { toastr.error('Error fetching approved leaves'); }
    }

    /* ── FETCH REJECTED ── */
    async function GetRejectedLeaves() {
        try {
            const res    = await fetch('/admin/leaves/rejected');
            const result = await res.json();
            if (res.ok) populate('rejectedLeaves', result.rejected.data, 'rejectedCount', 'rejected', false, 10);
            else toastr.error(result.error || 'Failed to load rejected leaves');
        } catch (e) { toastr.error('Error fetching rejected leaves'); }
    }

    /* ── APPROVE ── */
    async function approveLeave(leaveId) {
        try {
            const res    = await fetch('/admin/leavesaction', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
                body: JSON.stringify({ id: leaveId, approve: 1 }),
            });
            const result = await res.json();
            if (res.ok) {
                toastr.success(result.success || 'Leave approved');
                GetPendingLeaves(); GetApprovedLeaves(); GetRejectedLeaves();
            } else { toastr.error(result.error); }
        } catch (e) { toastr.error(String(e)); }
    }

    /* ── REJECT ── */
    async function rejectLeave(leaveId) {
        try {
            const res    = await fetch('/admin/leavesaction', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
                body: JSON.stringify({ id: leaveId, approve: 0 }),
            });
            const result = await res.json();
            if (res.ok) {
                toastr.success(result.success || '❌ Leave rejected');
                GetPendingLeaves(); GetApprovedLeaves(); GetRejectedLeaves();
            } else { toastr.error(result.error); }
        } catch (e) { toastr.error(String(e)); }
    }

    /* ── INIT ── */
    document.addEventListener('DOMContentLoaded', () => {
        GetPendingLeaves();
        GetApprovedLeaves();
        GetRejectedLeaves();
    });
</script>
</body>
</html>