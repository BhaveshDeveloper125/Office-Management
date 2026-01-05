<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Employees</title>
    <x-link />
</head>

<body class="h-screen w-screen flex">
    <x-employee-menu />
    <div class="flex-1">
        <div class=" p-2 flex ">
            <h1 class="w-[95%]  text-center">{{ Auth::user()->name }}</h1>
            <a href="" class="w-[5%]  flex justify-center items-center">
                <img src="" alt="  " class=" rounded-full object-cover">
            </a>
        </div>

        <div class="w-screen bg-green-500 flex gap-2 p-2 flex-wrap ">
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Attendance This Month</h1>
                    <span id="attendance"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Late This Month</h1>
                    <span id="late"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Early Leave This Month</h1>
                    <span id="early"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Absent This Month</h1>
                    <span id="absent"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>OverTime This Month</h1>
                    <span id="overtime"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Holiday This Month</h1>
                    <span id="holiday"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Total Working Days of This Month</h1>
                    <span id="workingdays"></span>
                </a>
            </div>
            <div class="size-40 bg-red-500 p-3">
                <a href="" class="size-full bg-yellow-500 block">
                    <h1>Remaining Working Days of This Month</h1>
                    <span id="remainingworkingdays"></span>
                </a>
            </div>
        </div>

        <form id="CheckIn">
            @csrf
            <div id="LiveClock"></div>
            <input type="submit" value="Check In">
        </form>

        <form id="CheckOut">
            @csrf
            <div id="LiveClock2"></div>
            <input type="submit" value="Check Out">
        </form>
    </div>

    {{-- Check In --}}
    <script>
        document.querySelector('#CheckIn').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/checkin', {
                    method: "POST",
                    body: new FormData(e.target)
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success);
                    console.log(result);
                } else {
                    toastr.error(result.error);
                }

            } catch (e) {
                toastr.error(e);
            }
        });
    </script>
    {{-- /Check In --}}

    {{-- Check Out --}}
    <script>
        document.querySelector('#CheckOut').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/checkout', {
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
    {{-- /Check Out --}}

    {{-- Timer --}}
    <script>
        setInterval(() => {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.querySelector('#LiveClock').textContent = timeString;
            document.querySelector('#LiveClock2').textContent = timeString;
        }, 1000);
    </script>
    {{-- /Timer --}}

    {{-- Cards --}}
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('/current_month_attendace_summary');
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result);
                    console.log('API Exception : ', result);
                } else {

                    let attendance = document.querySelector('#attendance');
                    attendance.innerHTML = '';
                    attendance.textContent = result.attendance;

                    let late = document.querySelector('#late');
                    late.innerHTML = '';
                    late.textContent = result.late;

                    let early = document.querySelector('#early');
                    early.innerHTML = '';
                    early.textContent = result.early;

                    let absent = document.querySelector('#absent');
                    absent.innerHTML = '';
                    absent.textContent = result.absent;

                    let overtime = document.querySelector('#overtime');
                    overtime.innerHTML = '';
                    overtime.textContent = result.overtime;
                }

            } catch (e) {
                console.log(e);
                toastr.error('API Error : ', e);

            }
        });
    </script>
    {{-- /Cards --}}

    {{-- Holiday --}}
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('/current_month_holiday');
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result);
                    console.log('API Exception : ', result);
                } else {

                    let holiday = document.querySelector('#holiday');
                    holiday.innerHTML = '';
                    holiday.textContent = result.holiday;

                }

            } catch (e) {
                console.log(e);
                toastr.error('API Error : ', e);
            }
        });
    </script>
    {{-- /Holiday --}}

    {{-- Total And Remaining Working Days Of This Month --}}
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('/current_month_workin_days');
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result);
                    console.log('API Exception : ', result);
                } else {
                    let workingdays = document.querySelector('#workingdays');
                    workingdays.innerHTML = '';
                    workingdays.textContent = result.currentworkingdays;

                    const today = new Date().getDate();

                    let remainingworkingdays = document.querySelector('#remainingworkingdays');
                    remainingworkingdays.innerHTML = '';
                    remainingworkingdays.textContent = result.remainingdays;

                }
            } catch (e) {
                console.log(e);
                toastr.error('API Error : ', e);
            }
        });
    </script>
    {{-- /Total And Remaining Working Days Of This Month --}}

</body>

</html>
