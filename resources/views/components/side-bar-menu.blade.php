<!-- ── HAMBURGER (mobile only) ── -->
<button class="sidebar-toggle" id="sidebarToggle" aria-label="Open menu">
    <i class="fa-solid fa-bars"></i>
</button>

<!-- ── OVERLAY (mobile only) ── -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ── SIDEBAR ── -->
<div class="menu-area" id="sidebarMenu">
    <!-- close button inside sidebar (mobile) -->
    <button class="sidebar-close" id="sidebarClose" aria-label="Close menu">
        <i class="fa-solid fa-xmark"></i>
    </button>

    {{-- <div class="logo">attnd.</div> --}}
    <div class="menu-items">
        <a class="menu-item {{ request()->path() === 'admin' ? 'active' : '' }}" href="/"><i class="fa-solid fa-chart-bar" style="color:#6C63FF;width:18px;"></i> Dashboard</a>
        <a class="menu-item {{ request()->is('emp_daily_attendance') ? 'active' : '' }}" href="/emp_daily_attendance"><i class="fa-solid fa-calendar-days" style="color:#4ECDC4;width:18px;"></i> Attendance</a>
        <a class="menu-item {{ request()->is('emp_details') ? 'active' : '' }}" href="/emp_details"><i class="fa-solid fa-users" style="color:#FDCB6E;width:18px;"></i> Employees</a>
        <a class="menu-item {{ request()->is('add_emp') ? 'active' : '' }}" href="/add_emp"><i class="fa-solid fa-user-plus" style="color:#4ECDC4;width:18px;"></i> Add New Employee</a>
        <a class="menu-item {{ request()->is('admin/search_emp') ? 'active' : '' }}" href="/admin/search_emp"><i class="fa-solid fa-magnifying-glass" style="color:#6C63FF;width:18px;"></i> Search Employee</a>
        <a class="menu-item {{ request()->is('manage_holiday') ? 'active' : '' }}" href="/manage_holiday"><i class="fa-solid fa-umbrella-beach" style="color:#2ecc71;width:18px;"></i> Holidays</a>
        <a class="menu-item {{ request()->is('emp_leave_management') ? 'active' : '' }}" href="/emp_leave_management"><i class="fa-solid fa-calendar-minus" style="color:#FF4C60;width:18px;"></i> Leaves</a>
        <a class="menu-item {{ request()->is('pay_leave') ? 'active' : '' }}" href="/pay_leave"><i class="fa-solid fa-money-bill-wave" style="color:#00ff6a;width:18px;"></i> Pay Leaves</a>
        {{-- <a class="menu-item" href="/emp_overtime_checkout"><i class="fa-solid fa-clock" style="color:#FDCB6E;width:18px;"></i> Overtime</a> --}}
        {{-- <a class="menu-item" href="/settings"><i class="fa-solid fa-gear" style="color:#7b8395;width:18px;"></i> Settings</a> --}}
        <form action="/logout" method="post"
            onsubmit="return confirm(' Are you sure you want to Logout from this system ? ')">
            @csrf
            <button type="submit" class="menu-item" style="border: none; background: transparent; width: 100%; text-align: left; font: inherit; color: inherit; cursor: pointer;">
                <i class="fa-solid fa-right-from-bracket" style="color:#FF4C60;width:18px;"></i> Logout
            </button>
        </form>
    </div>
</div>

<script>
    (function () {
        const toggle  = document.getElementById('sidebarToggle');
        const close   = document.getElementById('sidebarClose');
        const overlay = document.getElementById('sidebarOverlay');
        const sidebar = document.getElementById('sidebarMenu');

        function openSidebar()  { sidebar.classList.add('open');  overlay.classList.add('active'); }
        function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('active'); }

        toggle.addEventListener('click',  openSidebar);
        close.addEventListener('click',   closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    })();
</script>

