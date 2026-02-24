<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <x-link />
</head>

<body class="h-screen w-screen flex bg-black text-white">

    <x-side-bar-menu />
    <div class="flex-1">
        <form action="/change_password" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="email" value="{{ $user->email }}"> <br>
            <input type="password" name="password" placeholder="New Password" required> <br>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required> <br>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>

</html>
