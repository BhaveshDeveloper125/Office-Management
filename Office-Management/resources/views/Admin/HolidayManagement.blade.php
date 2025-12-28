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
        <h1>Weekend Management</h1>
        <form action="/add_weekend" method="post">
            @csrf
            <select name="day" id="date" required>
                <option value="" disabled selected>Select a Day</option>
                @foreach (config('WeeklyHoliday.days') as $key => $value)
                    <option value="{{ $value }}">{{ $key }}</option>
                @endforeach
            </select>
            <button type="submit">Add Holiday</button>
        </form>
    </div>
</body>

</html>
