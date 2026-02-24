<div class="menu-area">
    <nav class="menu-items">
        <a href="/" class="menu-item active">📊 Dashboard</a>
        <a href="/emp_attendance" class="menu-item">📅 Attendance</a>
        <a href="/emp_leave" class="menu-item">👥 Ask Leave</a>
        <a href="/attendance" class="menu-item">⚙️ Checkout/Overtime</a>
        <div class="menu-item">
            <form action="{{ route('logout') }}" method="post"
                onsubmit="return confirm('Are you sure you want to logout from this system ??')">
                @csrf
                <input type="submit" value="Logout">
            </form>           
        </div>
    </nav>
</div>
