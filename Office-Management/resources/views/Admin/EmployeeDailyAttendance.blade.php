<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance</title>
    <x-link />
</head>

<body class="h-screen w-screen flex bg-black text-white">
    <x-side-bar-menu />
    <div class="flex-1">
        <h1>Daily Attendance</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Post</th>
                <th>CheckIn</th>
                <th>CheckOut</th>
            </tr>
            <tbody id="attendanceTableBody"></tbody>
        </table>
    </div>

    <script>
        async function fetchAttendanceData() {
            try {
                const response = await fetch('/admin/daily_attendance');
                const result = await response.json();

                let data = result.dailyAttendance.data || [];
                

                const tableBody = document.getElementById('attendanceTableBody');
                tableBody.innerHTML = '';
                data.forEach(i => {
                    console.log(i);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${i.user.name}</td>
                        <td>${i.user.email}</td>
                        <td>${i.user.mobile}</td>
                        <td>${i.user.post}</td>
                        <td>${i.checkin}</td>
                        <td>${i.checkout}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }catch (error) {
                console.error('Error fetching attendance data:', error);
            }
        }
        fetchAttendanceData();
    </script>
</body>

</html>
