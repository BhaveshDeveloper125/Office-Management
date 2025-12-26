<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee Details</title>
    <x-link />
</head>

<body class="h-screen w-screen flex">
    <x-side-bar-menu />
    <div class="flex-1">
        <form action="{{route('UpdateEmpDetails')}}" method="post" id="edit_form">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{$user->id}}">
            <input type="text" name="name" id="name" value="{{$user->name}}"> <br>
            <input type="email" name="email" id="email" value="{{$user->email}}"> <br>
            <input type="text" name="post" id="post" value="{{$user->post}}"> <br>
            <input type="text" name="mobile" id="mobile" value="{{$user->mobile}}"> <br>
            <input type="text" name="address" id="address" value="{{$user->address}}"> <br>
            <input type="text" name="qualification" id="qualification" value="{{$user->qualification}}"> <br>
            <input type="text" name="experience" id="experience" value="{{$user->experience}}"> <br>
            <label for="joining">Joining Date</label>
            <input type="date" name="joining" id="joining" value="{{$user->joining}}"> <br>
            <label for="working_from">Choose Office Timing</label>
            <input type="time" name="working_from" id="working_from" value="{{$user->working_from}}"> <br>
            <input type="time" name="working_to" id="working_to" value="{{$user->working_to}}"> <br>
            <label for="working">Working/Notworking</label>
            <input type="hidden" name="working" value="0">
            <input type="checkbox" name="working" id="working" value="1" {{ $user->working ? 'checked' : '' }}> <br>
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>