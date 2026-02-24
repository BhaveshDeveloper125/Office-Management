<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday Management</title>
    <x-link />
</head>

<body class="h-screen w-screen flex bg-black text-white">
    <x-side-bar-menu />
    <div class="flex-1">
        <form id="WeekendHolidayForm">
            <h1>Weekend Management</h1>
            @csrf
            <select name="day" id="date" required>
                <option value="" disabled selected>Select a Day</option>
                @foreach (config('WeeklyHoliday.days') as $key => $value)
                    <option value="{{ $value }}">{{ $key }}</option>
                @endforeach
            </select>
            <button type="submit" id="add">Add Holiday</button>
            <button type="submit" id="remove">Remove Holiday</button>
        </form>

        <br>

        <table>
            <tr>
                <th>Sr No</th>
                <th>Days</th>
            </tr>
            <tbody id="WeekendTable"></tbody>
        </table>

        <br><br>

        <form id="HolidayForm">
            <h1>Set Holiday</h1>
            @csrf
            From : <input type="date" name="from" id="from" required>
            To : <input type="date" name="to" id="to" required><br>
            <input type="text" name="title" id="title" required placeholder="Holiday Title"><br>
            <textarea name="description" id="description" placeholder="Enter Description"></textarea> <br />
            <button type="submit" id="add_holiday">Set Holiday</button> <br>
            <button type="submit" id="remove_holiday">Remove Holiday</button>
            <p class="text-red-800">Enter same exact date to remove the Holiday</p>
        </form>

        <br>

        <table>
            <tr>
                <th>Sr No</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
            <tbody id="HolidayTable"></tbody>
        </table>

        {{-- ********************************************************** WEEKEND APIS ********************************************************** --}}

        {{-- Set Weekend --}}
        <script>
            document.querySelector('#add').addEventListener('click', async (e) => {
                e.preventDefault();
                let Form = document.querySelector('#WeekendHolidayForm');
                const formData = new FormData(Form);

                try {
                    const response = await fetch('/add_weekend', {
                        method: "POST",
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        GetWeekends();
                        toastr.success(result.success);
                    } else {
                        toastr.error(result.error);
                    }

                } catch (e) {
                    toastr.error(e);
                }

            });
        </script>
        {{-- /Set Weekend --}}

        {{-- Remove Weekend --}}
        <script>
            document.querySelector('#remove').addEventListener('click', async (e) => {
                e.preventDefault();
                let Form = document.querySelector('#WeekendHolidayForm');
                const formData = new FormData(Form);
                formData.append('_method', 'DELETE');

                try {
                    const response = await fetch('/remove_weekend', {
                        method: "POST",
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        GetWeekends();
                        toastr.success(result.success);
                    } else {
                        toastr.error(result.error);
                    }

                } catch (e) {
                    toastr.error(e);
                }

            });
        </script>
        {{-- /Remove Weekend --}}

        {{-- Fetch Weekly Holidays --}}
        <script>
            document.addEventListener('DOMContentLoaded', GetWeekends);

            async function GetWeekends() {
                const response = await fetch('/weekend');
                const result = await response.json();

                try {
                    if (response.ok) {
                        let WeekendTable = document.querySelector('#WeekendTable');
                        WeekendTable.innerHTML = '';

                        result.Days.forEach((i, index) => {
                            let tr = document.createElement('tr');
                            tr.innerHTML = `<td>${index+1}</td><td>${i}</td>`;

                            WeekendTable.appendChild(tr);
                        });
                    } else {
                        toastr.error(result.error);
                    }
                } catch (e) {
                    toastr.error(e);
                }
            }
        </script>
        {{-- /Fetch Weekly Holidays --}}

        {{-- ********************************************************** / WEEKEND APIS ********************************************************** --}}



        {{-- ********************************************************** NORMAL HOLIDAY APIS ********************************************************** --}}

        {{-- Add Normal Holiday --}}
        <script>
            document.querySelector('#add_holiday').addEventListener('click', async (e) => {
                e.preventDefault();
                try {
                    const form = document.querySelector('#HolidayForm');
                    const Body = new FormData(form);

                    const response = await fetch('/set_holiday', {
                        method: "POST",
                        body: Body,
                    });

                    const result = await response.json();

                    if (response.ok) {
                        toastr.success(result.success);
                        GetHoliday();
                    } else {
                        toastr.error(result.error);
                    }

                } catch (e) {
                    toastr.error(" API Error ", e);
                }
            });
        </script>
        {{-- /Add Normal Holiday --}}


        {{-- Fetch Normal Holiday --}}
        <script>
            document.addEventListener('DOMContentLoaded', GetHoliday);

            async function GetHoliday() {
                try {
                    const response = await fetch('/holidays');
                    const result = await response.json();

                    if (response.ok) {

                        let HolidayTable = document.querySelector('#HolidayTable');
                        HolidayTable.innerHTML = '';

                        console.log(result.Holiday);


                        result.Holiday.data.forEach((i, index) => {

                            let tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${index+1}</td>
                                <td>${i.from}</td>
                                <td>${i.to}</td>
                                <td>${i.days}</td>
                                <td>${i.title}</td>
                                <td>${i.description}</td>`;

                            HolidayTable.appendChild(tr);
                        });

                    } else {
                        toastr.error(result.error);
                    }

                } catch (e) {
                    toastr.error(e)
                }
            }
        </script>
        {{-- /Fetch Normal Holiday --}}


        {{-- Remove Normal Holiday --}}
        <script>
            document.querySelector('#remove_holiday').addEventListener('click', async (e) => {
                e.preventDefault();
                try {
                    const form = document.querySelector('#HolidayForm');
                    const Body = new FormData(form);
                    Body.append('_method', 'DELETE');

                    const response = await fetch('/remove_holiday', {
                        method: "POST",
                        body: Body,
                    });

                    const result = await response.json();

                    if (response.ok) {
                        toastr.success(result.success);
                        GetHoliday();
                    } else {
                        toastr.error(result.error);
                    }
                } catch (e) {
                    toastr.error(e);
                }
            });
        </script>
        {{-- /Remove Normal Holiday --}}

        {{-- ********************************************************** / NORMAL HOLIDAY APIS ********************************************************** --}}

    </div>
</body>

</html>
