<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <x-link />
</head>

<body class="flex">
    <form action="{{ route('login') }}" method="post">
        <input type="email" name="email" id="email" placeholder="Email" required>
        <br>
        <input type="password" name="password" id="password" placeholder="Password" readonly>
        <input type="submit" value="Login">

        @if ($errors->any())
            @foreach ($errors as $i)
                <p class="text-red-500">{{ $i }}</p>
            @endforeach
        @endif

    </form>
</body>

</html>
