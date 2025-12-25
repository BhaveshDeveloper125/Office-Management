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
        <form id="edit_form">
            <input type="text" name="name" id="name"> <br>
            <input type="email" name="email" id="email"> <br>
            <input type="text" name="post" id="post"> <br>
            <input type="text" name="mobile" id="mobile"> <br>
            <input type="text" name="address" id="address"> <br>
            <input type="text" name="qualification" id="qualification"> <br>
            <input type="text" name="experience" id="experience"> <br>
            <input type="date" name="joining" id="joining"> <br>
            <input type="date" name="working_from" id="working_from"> <br>
            <input type="date" name="working_to" id="working_to"> <br>
            <input type="checkbox" name="working" id="working"> <br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>