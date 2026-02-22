<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <x-link />
</head>

<body class="h-screen w-screen flex">
    <x-side-bar-menu />
    <div class="flex-1">
        <table>
            <h1>Pending Leaves</h1>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Post</th>
                <th>Mobile</th>
                <th>Leave Title</th>
                <th>Duration Type</th>
                <th>Leave Type</th>
                <th>Total Days</th>
                <th>From</th>
                <th>To</th>
                <th>Approval Status</th>
            </tr>
            <tbody id="pendingLeaves"></tbody>
        </table>

        <br>><br>

        <table>
            <h1>Approved Leaves</h1>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Post</th>
                <th>Mobile</th>
                <th>Leave Title</th>
                <th>Duration Type</th>
                <th>Leave Type</th>
                <th>Total Days</th>
                <th>From</th>
                <th>To</th>
                <th>Approval Status</th>
            </tr>
            <tbody id="approvedLeaves"></tbody>
        </table>

        <br><br>

        <table>
            <h1>Rejected Leaves</h1>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Post</th>
                <th>Mobile</th>
                <th>Leave Title</th>
                <th>Duration Type</th>
                <th>Leave Type</th>
                <th>Total Days</th>
                <th>From</th>
                <th>To</th>
                <th>Approval Status</th>
            </tr>
            <tbody id="rejectedLeaves"></tbody>
        </table>
    </div>

    {{-- Get Pending Leaves --}}
    <script>
        document.addEventListener('DOMContentLoaded', GetPendingLeaves);
        async function GetPendingLeaves() {
            try {
                const response = await fetch('/admin/leaves/pending');
                const result = await response.json();
                if (response.ok) {

                    let data = result.pending.data;

                    data.forEach(i => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${i.user.name}</td>
                            <td>${i.user.email}</td>
                            <td>${i.user.post}</td>
                            <td>${i.user.mobile}</td>
                            <td>${i.title}</td>
                            <td>${i.duration_type}</td>
                            <td>${i.leave_type}</td>
                            <td>${i.total_days}</td>
                            <td>${i.from}</td>
                            <td>${i.to}</td>
                            <td>${i.approval == null ? 'Pending' : (i.approval ? 'Approved' : 'Rejected')}</td>
                        `;
                        document.getElementById('pendingLeaves').appendChild(tr);
                    });

                } else {
                    toastr.error('Invalid response while fetching pending leaves');
                }
            } catch (e) {
                toastr.error('Error fetching pending leaves');
            }    
        }
    </script>

    {{-- Get Approved Leaves --}}
    <script>
        document.addEventListener('DOMContentLoaded', GetApprovedLeaves);
        async function GetApprovedLeaves() {
            try {
                const response = await fetch('/admin/leaves/approved');
                const result = await response.json();
                if (response.ok) {
                   
                    let data = result.approved.data;                    

                    data.forEach(i => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${i.user.name}</td>
                            <td>${i.user.email}</td>
                            <td>${i.user.post}</td>
                            <td>${i.user.mobile}</td>
                            <td>${i.title}</td>
                            <td>${i.duration_type}</td>
                            <td>${i.leave_type}</td>
                            <td>${i.total_days}</td>
                            <td>${i.from}</td>
                            <td>${i.to}</td>
                            <td>${i.approval == null ? 'Pending' : (i.approval ? 'Approved' : 'Rejected')}</td>
                        `;
                        document.getElementById('approvedLeaves').appendChild(tr);
                    });

                } else {
                    toastr.error('Invalid response while fetching approved leaves');
                }
            } catch (e) {
                toastr.error('Error fetching approved leaves');
            }    
        }
    </script>

    {{-- Get Rejected Leaves --}}
    <script>
        document.addEventListener('DOMContentLoaded', GetRejectedLeaves);
        async function GetRejectedLeaves() {
            try {
                const response = await fetch('/admin/leaves/rejected');
                const result = await response.json();
                if (response.ok) {
                    let data = result.rejected.data;
                    data.forEach(i => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${i.user.name}</td>
                            <td>${i.user.email}</td>
                            <td>${i.user.post}</td>
                            <td>${i.user.mobile}</td>
                            <td>${i.title}</td>
                            <td>${i.duration_type}</td>
                            <td>${i.leave_type}</td>
                            <td>${i.total_days}</td>
                            <td>${i.from}</td>
                            <td>${i.to}</td>
                            <td>${i.approval == null ? 'Pending' : (i.approval ? 'Approved' : 'Rejected')}</td>
                        `;
                        document.getElementById('rejectedLeaves').appendChild(tr);
                    });
                } else {
                    toastr.error('Invalid response while fetching rejected leaves');
                }
            } catch (e) {
                toastr.error('Error fetching rejected leaves');
            }    
        }
    </script>
</body>

</html>