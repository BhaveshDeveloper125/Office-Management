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
    <x-side-bar-menu />
    <div class="flex-1">
        <form id="AddEmployeeForm">
            @csrf
            <input type="text" name="name" id="name" placeholder="Name" required><br>
            <input type="email" name="email" id="email" placeholder="Email" required><br>
            <input type="text" name="post" id="post" placeholder="Post" required><br>
            <input type="number" name="mobile" id="mobile" placeholder="Mobile" min="0" maxlength="10"
                minlength="10" placeholder="Mobile" required> <br>
            <input type="text" name="qualification" id="qualification" placeholder="Qualification" required> <br>
            <input type="number" name="experience" id="experience" placeholder="Experience in Years" min="0"
                required> <br>

            <label for="">Joining Date</label>
            <input type="date" name="joining" id="joining" required> <br>

            <h1>Set Working Time</h1>
            <label for="">from</label>
            <input type="time" name="working_from" id="working_from" required> <br>

            <label for="">to</label>
            <input type="time" name="working_to" id="working_to" required> <br>

            <textarea name="address" id="address" placeholder="Address" required></textarea> <br>

            <input type="password" name="password" id="password" placeholder="Password" required> <br>
            <input type="password" name="password_confirmation" id="password_confirmation"
                placeholder="Confirm Password" required> <br>

            <select name="role" id="role_container">
                <option disabled selected>Select Role</option>
            </select><br>

            <input type="number" name="hours" id="hours" required placeholder="Expected Working Hours"> <br>

            <input type="submit" value="Add">
        </form>
    </div>

    <!-- Creating New Employee -->
    <script>
        async function AddEmployee(e) {
            try {
                e.preventDefault();
                let Form = document.querySelector('#AddEmployeeForm');
                let Formdata = new FormData(Form);

                // Get CSRF token from the form
                const csrfToken = document.querySelector('input[name="_token"]').value;

                const response = await fetch('/registration', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: Formdata
                });

                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result.error);
                    return;
                }

                toastr.success(result.success);
                Form.reset();

            } catch (e) {
                toastr.error(e);
            }
        }
        document.querySelector('#AddEmployeeForm').addEventListener('submit', AddEmployee);
    </script>

    <!-- Fetching Admin Roles -->
    <script>
        async function GetRoles() {
            try {
                const response = await fetch('/roles');
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result.error);
                }

                const roleSelect = document.querySelector('#role_container');
                result.roles.forEach(i => {
                    const option = document.createElement('option');
                    option.value = i.name;
                    option.textContent = i.name;
                    roleSelect.appendChild(option);
                });
            } catch (e) {
                toastr.error("API fetching error : ", e);
            }
        }
        document.addEventListener('DOMContentLoaded', GetRoles);
    </script>
</body>

</html>
