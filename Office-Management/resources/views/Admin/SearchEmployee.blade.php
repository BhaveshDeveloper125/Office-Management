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
    <x-side-bar-menu />
    <div class="flex-1">
        <form action="/search_employee" method="post" id="searchform">
            @csrf
            <input type="text" name="search" placeholder="Search by name or email" required>
            <button type="submit">Search</button>
        </form>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Post</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Qualification</th>
                <th>Experience</th>
                <th>Joining</th>
                <th>Working From</th>
                <th>Working To</th>
                <th>Edit</th>
                <th>Change Password</th>
            </tr>
            <tbody id="searchResults"></tbody>
        </table>

    </div>

    <script>
        document.querySelector('#searchform').addEventListener('submit', searchEmployee);

        async function searchEmployee(e) {
            e.preventDefault();
            const searchQuery = document.querySelector('input[name="search"]').value;
            try {
                const response = await fetch('/search_employee', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ search: searchQuery })
                });
                const data = await response.json();
                console.log(data.EmpDetails);
                data.EmpDetails.forEach(i => {
                    let tr = document.createElement('tr');
                    const row = `<tr>
                        <td>${i.name}</td>
                        <td>${i.email}</td>
                        <td>${i.post}</td>
                        <td>${i.mobile}</td>
                        <td>${i.address}</td>
                        <td>${i.qualification}</td>
                        <td>${i.experience}</td>
                        <td>${i.joining_date}</td>
                        <td>${i.working_from}</td>
                        <td>${i.working_to}</td>
                        <td><a href="/edit_employee/${i.id}">View</a></td>
                        <td><a href="/edit_password/${i.id}">Change Password</a></td>
                    </tr>`;
                    document.querySelector('#searchResults').innerHTML = '';
                    document.querySelector('#searchResults').insertAdjacentHTML('beforeend', row);
                });
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
</body>

</html>
