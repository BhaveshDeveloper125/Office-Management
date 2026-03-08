<!-- ── SIDEBAR ── -->
<div class="menu-area">
    {{-- <div class="logo">attnd.</div> --}}
    <div class="menu-items">
        <a class="menu-item active" href="/">📊 Dashboard</a>
        <a class="menu-item" href="/emp_daily_attendance">🗓 Attendance</a>
        <a class="menu-item" href="/emp_details">👥 Employees</a>
        <a class="menu-item" href="/add_emp">Add New Employee</a>
        <a class="menu-item" href="/admin/search_emp">Search Employee</a>
        <a class="menu-item" href="/manage_holiday">🎉 Holidays</a>
        <a class="menu-item" href="/emp_leave_management">🌿 Leaves</a>
        {{-- <a class="menu-item" href="/emp_overtime_checkout">⏱ Overtime</a> --}}
        {{-- <a class="menu-item" href="/settings">⚙️ Settings</a> --}}
        <a>
            <form action="/logout" method="post"
                onsubmit="return confirm(' Are you sure you want to Logout from this system ? ')">
                @csrf
                <input type="submit" value="Logout">
            </form>
        </a>
    </div>
</div>

