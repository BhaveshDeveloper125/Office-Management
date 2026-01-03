<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overtime or Forgot Checkout</title>
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

    </div>


</body>

</html>
