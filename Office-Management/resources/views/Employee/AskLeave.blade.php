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
    <x-employee-menu />
    <div class="flex-1">
        <x-employee-page-header />

        <form id="leave_form" onsubmit="return confirm('Are you sure you want to request this leave permission ? ')">
            @csrf
            <input type="text" name="title" id="title" placeholder="Enter leave title" required> <br>
            <select name="duration_type" id="duration_type" required>
                <option value="half">Half</option>
                <option value="full">Full</option>
            </select>
            <input type="date" name="from" id="from" placeholder="Select start date" required><br>
            <input type="date" name="to" id="to" placeholder="Select end date" required><br>
            <select name="leave_type" id="leave_type" required>
                <option value="casual">casual</option>
                <option value="medical">medical</option>
                <option value="other">other</option>
            </select>
            <textarea name="description" id="description" placeholder="Describe your leave request" required></textarea>
            <input type="submit" value="Request">
        </form>

        <table>
            <tr>
                <th>Title</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Leave Type</th>
                <th>Description</th>
                <th>Approve</th>
            </tr>
            <tbody id="leaveTable"></tbody>
        </table>

        {{-- Submit Leave Request --}}
        <script>
            document.querySelector('#leave_form').addEventListener('submit', async (e) => {
                e.preventDefault();
                try {
                    const response = await fetch('/create_leave', {
                        method: "POST",
                        body: new FormData(e.target),
                    });
                    const result = await response.json();

                    if (!response.ok) {
                        toastr.error(result.error);
                    } else {
                        toastr.success(result.success);
                    }

                } catch (e) {
                    toastr.error(e)
                }
            });
        </script>
        {{-- /Submit Leave Request --}}

        {{-- Get Leaves --}}
        <script>
            try {
                document.addEventListener('DOMContentLoaded', async () => {
                    const response = await fetch('/getempleave');
                    const result = await response.json();

                    if (!response.ok) {
                        toastr.error(result.error);
                    } else {

                        let leaveTable = document.querySelector('#leaveTable');
                        leaveTable.innerHTML = '';

                        result.leaves.data.forEach(i => {
                            let tr = document.createElement('tr');
                            tr.innerHTML = `
                                <th>${i.title}</th>
                                <th>${i.from}</th>
                                <th>${i.to}</th>
                                <th>${ (new Date(i.to).getTime() - new Date(i.from).getTime()) / (1000 * 60 * 60 * 24) + 1 }</th>
                                <th>${i.leave_type}</th>
                                <th>${i.description}</th>
                                <th>${i.approve}</th>
                            `;
                            leaveTable.appendChild(tr);
                        });

                    }

                });
            } catch (e) {
                toastr.error(e);
            }
        </script>
        {{-- /Get Leaves --}}

    </div>

</body>

</html>
