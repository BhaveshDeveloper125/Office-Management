<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <x-link />
</head>

<body class="h-screen w-screen flex">

    <x-side-bar-menu />
    <div class="flex-1">

        <form id="filter">
            <h2>Filter According to Joining Date</h2>
            @csrf
            <input type="date" name="from" id="from">
            <input type="date" name="to" id="to">
            <button type="submit">Filter</button>
        </form>

        <form id="SearchForm">
            @csrf
            <input type="search" name="search" id="search" placeholder="Search Employee Name Name">
            <input type="submit" value="Search">
        </form>

        <table class="hidden" id="SearchTable">
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
                <th>Working</th>
                <th>Action</th>
            </tr>
            <tbody id="EmpSearch"></tbody>
        </table>

        <table id="filter_table" class="hidden">
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
                <th>Working</th>
                <th>Action</th>
            </tr>
            <tbody id="filter_emp_details"></tbody>
        </table>

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
                <th>Working</th>
                <th>Action</th>
                <th>Change Password</th>
            </tr>
            <tbody id="emp_details"></tbody>
        </table>
    </div>

    <!-- Search Employee -->
    <script>
        document.querySelector('#SearchForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch('/search_employee', {
                    method: 'POST',
                    body: new FormData(e.target)
                });

                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result.error);
                } else {

                    if (!result.EmpDetails || result.EmpDetails.length === 0) {
                        toastr.error("No Data Found");
                    } else {

                        document.querySelector('#SearchTable').classList.remove('hidden');

                        let EmpSearch = document.querySelector('#EmpSearch');
                        EmpSearch.innerHTML = '';

                        const empData = result.EmpDetails.data || result.EmpDetails;
                        empData.forEach(i => {
                            let tr = document.createElement('tr');
                            tr.innerHTML = `<td>${i.name}</td>
                            <td>${i.email}</td>
                            <td>${i.post}</td>
                            <td>${i.mobile}</td>
                            <td>${i.address}</td>
                            <td>${i.qualification}</td>
                            <td>${i.experience}</td>
                            <td>${i.joining}</td>
                            <td>${i.working_from}</td>
                            <td>${i.working_to}</td>
                            <td>${i.working ? 'Employee' : 'X Employee'}</td>
                            <td><a target="_blank" href="/edit_employee/${i.id}">Edit</a></td>`;
                            EmpSearch.appendChild(tr);
                        });

                        console.log("Search", result.EmpDetails);
                    }

                }
            } catch (e) {
                toastr.error(e);
            }
        });
    </script>

    <!-- Filter Employee Lists -->
    <script>
        async function FilterEmployee(e) {
            e.preventDefault();
            const resposne = await fetch('/filter_employee', {
                method: 'POST',
                body: new FormData(e.target)
            });
            const result = await resposne.json();

            if (!resposne.ok) {
                toastr.error(result.error);
            } else {
                let FilterTable = document.querySelector('#filter_table');
                FilterTable.classList.remove('hidden');

                let FilterEmpDetails = document.querySelector('#filter_emp_details');
                FilterEmpDetails.innerHTML = '';

                console.log(result.EmpDetails.data);

                result.EmpDetails.data.forEach(i => {
                    let tr = document.createElement('tr');
                    tr.innerHTML = `<td>${i.name}</td>
                    <td>${i.email}</td>
                    <td>${i.post}</td>
                    <td>${i.mobile}</td>
                    <td>${i.address}</td>
                    <td>${i.qualification}</td>
                    <td>${i.experience}</td>
                    <td>${i.joining}</td>
                    <td>${i.working_from}</td>
                    <td>${i.working_to}</td>
                    <td>${i.working ? 'Employee' : 'X Employee'}</td>
                    <td><a target="_blank" href="/edit_employee/${i.id}">Edit</a></td>`;
                    FilterEmpDetails.appendChild(tr);
                });
            }
        }
        document.querySelector('#filter').addEventListener('submit', FilterEmployee);
    </script>

    <!-- Fetch Employee List -->
    <script>
        async function EmployeeList(e) {
            e.preventDefault();
            const resposne = await fetch('/emp_list');
            const result = await resposne.json();

            if (!resposne.ok) {
                toastr.error(error);
            } else {
                let EmpDetails = document.querySelector('#emp_details');
                EmpDetails.innerHTML = '';

                result.EmpDetails.data.forEach(i => {
                    let tr = document.createElement('tr');
                    tr.innerHTML = `<td>${i.name}</td>
                    <td>${i.email}</td>
                    <td>${i.post}</td>
                    <td>${i.mobile}</td>
                    <td>${i.address}</td>
                    <td>${i.qualification}</td>
                    <td>${i.experience}</td>
                    <td>${i.joining}</td>
                    <td>${i.working_from}</td>
                    <td>${i.working_to}</td>
                    <td>${i.working ? 'Employee' : 'X Employee'}</td>
                    <td><a target="_blank" href="/edit_employee/${i.id}">Edit</a></td>
                    <td><a target="_blank" href="/edit_password/${i.id}">Change</a></td>`;
                    EmpDetails.appendChild(tr);
                });
            }
        }
        document.addEventListener('DOMContentLoaded', EmployeeList);
    </script>
</body>

</html>
