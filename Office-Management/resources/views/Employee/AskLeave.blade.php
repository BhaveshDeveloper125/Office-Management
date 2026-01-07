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
    <x-employee-menu />
    <div class="flex-1">
        <x-employee-page-header />

        <form action="{{ route('CreateLeave') }}" method="post" onsubmit="return confirm('Are you sure you want to request this leave permission ? ')">
            @csrf
            <input type="text" name="title" id="title" placeholder="Enter leave title" required> <br>
            <select name="duration_type" id="duration_type" required>
                <option value="half">Half</option>
                <option value="full">Full</option>
            </select>
            <input type="date" name="from" id="from" placeholder="Select start date" required><br>
            <input type="date" name="to" id="to" placeholder="Select end date" required><br>
            <select name="leave_type" id="leave_type" required>
                <option value="casual">casual</option>
                <option value="medical">medical</option>
                <option value="other">other</option>
            </select>            
            <textarea name="description" id="description" placeholder="Describe your leave request" required></textarea>
            <input type="submit" value="Request">
        </form>

    </div>

</body>

</html>
