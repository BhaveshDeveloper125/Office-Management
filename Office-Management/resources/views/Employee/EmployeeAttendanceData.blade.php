<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Employees</title>
    <x-link />
</head>

<body class="h-screen w-screen flex text-white bg-black">
    <x-employee-menu />
    <div class="flex-1">
        <x-employee-page-header />
        <h1>Employee Attendance Data</h1>
        <form action="/attendance_data" method="post" id="attendance_data">
            @csrf
            <select name="attendanceData" id="attendanceData" class="text-black">
                <option disabled selected>Select Type</option>
                <option value="attendance">Attendance</option>
                <option value="late">Late</option>
                <option value="early">Early Leave</option>
                <option value="absent">Absent</option>
                <option value="overtime">Overtime</option>
                <option value="holiday">Holiday</option>
                <option value="workingdays">Working Days</option>
                <option value="remainingworkingdays">Remaining Working Days</option>
            </select>
            <input type="submit" value="Get Report">

            <script>
                document.querySelector('#attendance_data').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    try {
                        const response = await fetch('/attendance_data', {
                            method: "POST",
                            body: new FormData(e.target)
                        });

                        const result = await response.json();

                        if (response.ok) {
                            toastr.success(result.success);
                        } else {
                            toastr.error(result.error);
                        }

                    } catch (e) {
                        toastr.error(e);
                    }
                });
            </script>

        </form>
    </div>

</body>

</html>