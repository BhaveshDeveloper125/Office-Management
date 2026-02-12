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
        <h1>Employee Attendance Data</h1>
        <x-emp-data-filter />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async ()=>{
            try {
                const response = await fetch('/employee_attendance_data');
                const result = await response.json();

                if (response.ok) {
                    console.log(result);
                    toastr.success(result);
                } else {
                    toastr.error(result.error);                    
                }


            } catch (e) {
                toastr.error(e);
            }
        });
    </script>

</body>

</html>