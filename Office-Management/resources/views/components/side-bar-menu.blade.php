<nav>
    <a href="">Dashboard</a>
    <br>
    <a href="">Employee Attendance</a>
    <br>
    <a href="/emp_details">Employee Details</a>
    <br>
    <a href="/add_emp">Add New Employee</a>
    <br>
    <a href="/search_emp">Search Employee</a>
    <br>
    <a href="/manage_holiday">Holiday management</a>
    <br>
    <a href="">Employee Leave Request</a>
    <br>
    <!-- <a href="">Mark as Overtime/Checkout</a> -->
    <!-- <br> -->
    <!-- <a href="">Permissions</a> -->
    <!-- <br> -->
    <a>
        <form action="/logout" method="post"
            onsubmit="return confirm(' Are you sure you want to Logout from this system ? ')">
            @csrf
            <input type="submit" value="Logout">
        </form>
    </a>
</nav>
