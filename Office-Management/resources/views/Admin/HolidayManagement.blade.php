<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday Management</title>
    <x-link />
</head>

<body class="h-screen w-screen flex">
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

        <form action="/set_holiday" method="post">
            <h1>Set Holiday</h1>
            @csrf
            <input type="date" name="date" id="date" required><br>
            <input type="text" name="title" id="title" required placeholder="Holiday Title"><br>
            <textarea name="description" id="description" placeholder="Enter Description"></textarea>
            <input type="submit" value="Set">
        </form>

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
    </div>
</body>

</html>
