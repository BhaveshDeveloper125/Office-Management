<nav>
    <a href="/">Dashboard</a>
    <br>
    <a href="/emp_attendance">Attendance</a>
    <br>
    <a href="/emp_leave">Ask Leave</a>
    <br>
    <a href="/attendance">Checkout/Overtime</a>
    <br>
    <form action="{{ route('logout') }}" method="post"
        onsubmit="return confirm('Are you sure you want to logout from this system ??')">
        @csrf
        <input type="submit" value="Logout">
    </form>
</nav>
