<div class="menu-area">
    <nav class="menu-items">
        <a href="/" class="menu-item {{ request()->path() === '/' ? 'active' : '' }}"><i class="fa-solid fa-chart-bar" style="color:#6C63FF;width:18px;"></i> Dashboard</a>
        <a href="/emp_attendance" class="menu-item {{ request()->is('emp_attendance') ? 'active' : '' }}"><i class="fa-solid fa-calendar-days" style="color:#4ECDC4;width:18px;"></i> Attendance</a>
        <a href="/emp_leave" class="menu-item {{ request()->is('emp_leave') ? 'active' : '' }}"><i class="fa-solid fa-calendar-minus" style="color:#2ecc71;width:18px;"></i> Ask Leave</a>
        <a href="/attendance" class="menu-item {{ request()->is('attendance') ? 'active' : '' }}"><i class="fa-solid fa-clock" style="color:#FDCB6E;width:18px;"></i> Checkout/Overtime</a>
        <form action="{{ route('logout') }}" method="post"
            onsubmit="return confirm('Are you sure you want to logout from this system ??')">
            @csrf
            <button type="submit" class="menu-item" style="border: none; background: transparent; width: 100%; text-align: left; font: inherit; color: inherit; cursor: pointer;">
                <i class="fa-solid fa-right-from-bracket" style="color:#FF4C60;width:18px;"></i> Logout
            </button>
        </form>
    </nav>
</div>
