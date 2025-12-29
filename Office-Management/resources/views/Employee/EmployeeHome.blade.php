<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Employees</title>
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

        <form id="CheckIn">
            @csrf
            <input type="submit" value="Check In">
        </form>

        <form id="CheckOut">
            @csrf
            <input type="submit" value="Check Out">
        </form>
    </div>

    {{-- Check In --}}
    <script>
        document.querySelector('#CheckIn').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/checkin', {
                    method: "POST",
                    body: new FormData(e.target)
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success);
                    console.log(result);
                } else {
                    toastr.error(result.error);
                }

            } catch (e) {
                toastr.error(e);
            }
        });
    </script>
    {{-- /Check In --}}

    {{-- Check Out --}}
    <script>
        document.querySelector('#CheckOut').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/checkout', {
                    method: "POST",
                    body: new FormData(e.target)
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.success(result.success);
                } else {
                    toastr.error(result.error);
                }

            } catch (e) {
                toastr.error(e);
            }
        });
    </script>
    {{-- /Check Out --}}

</body>

</html>
