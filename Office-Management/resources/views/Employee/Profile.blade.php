<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <x-link />
</head>

<body class="h-screen w-screen flex bg-black text-white">
    <x-employee-menu />
    <div class="flex-1">
        <x-employee-page-header />
        <form action="/update_user" method="post">
            @csrf
            @method('PUT')
            {{-- <input type="file" name="photo" value="{{ Auth::user()->photo }}" id=""> <br> --}}
            <input type="text" name="name" value="{{ auth()->user()->name }}" id="name"
                placeholder="Name"><br>
            <input type="email" name="email" value="{{ auth()->user()->email }}" id="email"
                placeholder="Email"><br>
            <input type="text" name="post" value="{{ auth()->user()->post }}" id="post"
                placeholder="Post"><br>
            <input type="number" name="mobile" value="{{ auth()->user()->mobile }}" id="mobile"
                placeholder="Mobile" min="0" maxlength="10" minlength="10" placeholder="Mobile"> <br>
            <input type="text" name="qualification" value="{{ auth()->user()->qualification }}" id="qualification"
                placeholder="Qualification"> <br>
            <input type="number" name="experience" value="{{ auth()->user()->experience }}" id="experience"
                placeholder="Experience in Years" min="0">
            <br>

            <textarea name="address" id="address" placeholder="Address">{{ auth()->user()->address }}</textarea> <br>

            <input type="submit" value="Update">

            @if ($errors->any())
                @foreach ($errors as $i)
                    <p class="text-red-500">{{ $i }}</p>
                @endforeach
            @endif

        </form>
    </div>


</body>

</html>
