<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay Leaves • Management</title>
    <x-link />

    <style>
        .content {
            padding: 2.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

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

        .section-header.pay::before {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .count-badge {
            margin-left: auto;
            font-size: 0.73rem;
            border-radius: 20px;
            padding: 0.2rem 0.75rem;
            font-weight: 600;
        }

        .count-badge.pay {
            background: rgba(46,204,113,0.12);
            color: #2ecc71;
            border: 1px solid rgba(46,204,113,0.25);
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
            background: #2ecc71;
        }

        .pay-card thead tr {
            background: linear-gradient(135deg, rgba(46,204,113,0.07), rgba(46,204,113,0.03));
        }

        .table-wrap { overflow-x: auto; position: relative; z-index: 1; }

        table { width: 100%; border-collapse: collapse; font-size: 0.87rem; }

        thead tr { border-bottom: 1px solid var(--card-border); }

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

        .empty-row td {
            padding: 2.5rem;
            text-align: center;
            color: var(--text-soft);
            font-style: italic;
        }

        @keyframes row-in {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        tbody tr { animation: row-in 0.28s ease both; }

        @media (max-width: 900px) {
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

    <div class="main">

        <!-- header -->
        <div class="header-area">
            <div class="page-title">
                <i class="fa-solid fa-money-bill-wave" style="color:#2ecc71;"></i>
                Pay <span>Leaves</span>
            </div>
            <div class="theme-toggle">
                <button class="theme-option active" data-theme="light"><i class="fa-solid fa-sun" style="color:#FDCB6E;"></i> light</button>
                <button class="theme-option" data-theme="dark"><i class="fa-solid fa-moon" style="color:#6C63FF;"></i> dark</button>
            </div>
        </div>

        <!-- content -->
        <div class="content">

            <div>
                <div class="section-header pay">
                    Applied Pay Leaves
                    <span class="count-badge pay" id="payLeaveCount">loading…</span>
                </div>

                <div class="table-card pay-card" id="payLeaveCard">
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Post</th>
                                    <th>Mobile</th>
                                    <th>Leave</th>
                                    <th>Year</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="AppliedLeaves">
                                <tr class="empty-row"><td colspan="11">Loading…</td></tr>
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
    const payCard = document.getElementById('payLeaveCard');
    if (payCard) {
        payCard.addEventListener('mousemove', e => {
            const r = payCard.getBoundingClientRect();
            payCard.style.setProperty('--x', ((e.clientX - r.left) / r.width  * 100) + '%');
            payCard.style.setProperty('--y', ((e.clientY - r.top)  / r.height * 100) + '%');
        });
    }

    /* ── HELPERS ── */
    const csrf = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function leaveTypeBadge(type) {
        const cls = { casual: 'lt-casual', medical: 'lt-medical', other: 'lt-other' }[type] || 'lt-other';
        return `<span class="leave-type-badge ${cls}">${type}</span>`;
    }

    /* ── FETCH ── */
    async function FetchAppliedPayLeave() {
        try {
            const response = await fetch('/applied_leave');
            const result   = await response.json();console.log(result);

            if (!response.ok) {
                throw new Error(result.error || 'Failed to load pay leaves');
            }

            const tbody = document.getElementById('AppliedLeaves');
            tbody.innerHTML = '';

            const data = result.appliedLeaves;
            document.getElementById('payLeaveCount').textContent =
                `${data.length} leave${data.length !== 1 ? 's' : ''}`;

            if (!data.length) {
                tbody.innerHTML = `<tr class="empty-row"><td colspan="11">No pay leave applications found.</td></tr>`;
                return;
            }

            data.forEach((i, idx) => {
                const tr = document.createElement('tr');
                tr.style.animationDelay = `${idx * 35}ms`;
                tr.innerHTML = `
                    <td class="name-cell">${i.user.name}</td>
                    <td class="email-cell">${i.user.email}</td>
                    <td><span class="post-badge">${i.user.post}</span></td>
                    <td class="mono-cell">${i.user.mobile}</td>
                    <td><span class="days-num">${i.leaves}</span></td>
                    <td class="mono-cell">${i.year_extracted}</td>
                    <td>
                        <button class="approve-btn" onclick="approvePayLeave(${i.id})">
                            <i class="fa-solid fa-check" style="color:#2ecc71;"></i> Approve
                        </button>
                        <button class="reject-btn" onclick="rejectPayLeave(${i.id})">
                            ✗ Reject
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

        } catch (e) {
            toastr.error(e.message || 'Error fetching pay leaves');
            document.getElementById('AppliedLeaves').innerHTML =
                `<tr class="empty-row"><td colspan="11">Failed to load records.</td></tr>`;
            document.getElementById('payLeaveCount').textContent = '—';
        }
    }

    /* ── APPROVE ── */
    async function approvePayLeave(id) {
        try {
            const res    = await fetch('/pay_leave_approve', {
                method:  'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
                body:    JSON.stringify({ id }),
            });
            const result = await res.json();
            if (res.ok) {
                toastr.success(result.success || 'Pay leave approved');
                FetchAppliedPayLeave();
            } else {
                toastr.error(result.error || 'Failed to approve');
            }
        } catch (e) {
            toastr.error(e.message || 'Error approving pay leave');
        }
    }

    /* ── REJECT ── */
    async function rejectPayLeave(id) {
        try {
            const res    = await fetch('/pay_leave_reject', {
                method:  'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf() },
                body:    JSON.stringify({ id }),
            });
            const result = await res.json();
            if (res.ok) {
                toastr.success(result.success || 'Pay leave rejected');
                FetchAppliedPayLeave();
            } else {
                toastr.error(result.error || 'Failed to reject');
            }
        } catch (e) {
            toastr.error(e.message || 'Error rejecting pay leave');
        }
    }

    /* ── INIT ── */
    document.addEventListener('DOMContentLoaded', FetchAppliedPayLeave);
</script>
</body>
</html>