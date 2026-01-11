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

        <br><br>

        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2 text-left">Title</th>
                    <th class="p-2 text-left">From</th>
                    <th class="p-2 text-left">To</th>
                    <th class="p-2 text-left">Days</th>
                    <th class="p-2 text-left">Leave Type</th>
                    <th class="p-2 text-left">Description</th>
                    <th class="p-2 text-left">Approve</th>
                </tr>
            </thead>
            <tbody id="leaveTable"></tbody>
        </table>
        <div id="paginationContainer"></div>


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
                        GetEmpLeaves();
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
            async function GetEmpLeaves(page) {
                try {
                    let currentPage = 1;

                    page = page || currentPage;
                    currentPage = page;

                    leaveTable.innerHTML = '<tr><td colspan="7" class="text-center p-4">Loading...</td></tr>';

                    const response = await fetch(`/getempleave?page=${page}`);
                    const result = await response.json();

                    if (!response.ok) {
                        toastr.error(result.error);
                    } else {

                        let leaveTable = document.querySelector('#leaveTable');
                        leaveTable.innerHTML = '';

                        result.leaves.data.forEach(i => {
                            let tr = document.createElement('tr');

                            let approval;

                            switch (i.approve) {
                                case null:
                                    approval = '<span class="text-gray-500">Not Reviewed</span>';
                                    break;

                                case true:
                                case 1:
                                    approval = '<span class="text-green-500">Approved</span>';
                                    break;

                                case false:
                                case 0:
                                    approval = '<span class="text-red-500">Rejected</span>';
                                    break;

                                default:
                                    approval = '<span class="text-gray-500">Unknown</span>';
                                    break;
                            }

                            tr.innerHTML = `
                                <td class="p-2 border-b border-gray-700">${i.title}</td>
                                <td class="p-2 border-b border-gray-700">${i.from}</td>
                                <td class="p-2 border-b border-gray-700">${i.to}</td>
                                <td class="p-2 border-b border-gray-700">${ (new Date(i.to).getTime() - new Date(i.from).getTime()) / (1000 * 60 * 60 * 24) + 1 }</td>
                                <td class="p-2 border-b border-gray-700">${i.leave_type}</td>
                                <td class="p-2 border-b border-gray-700">${i.description}</td>
                                <td class="p-2 border-b border-gray-700">${approval}</td>
                            `;
                            leaveTable.appendChild(tr);
                        });

                        // Pagination start
                        let paginationContainer = document.querySelector('#paginationContainer');
                        paginationContainer.innerHTML = '';

                        let jumpToFirstPageBtn = document.createElement('button');
                        jumpToFirstPageBtn.innerText = '<<';
                        jumpToFirstPageBtn.classList = 'p-4';
                        jumpToFirstPageBtn.onclick = () => GetEmpLeaves(1);

                        let prevPageBtn = document.createElement('button');
                        prevPageBtn.innerText = 'prev';
                        prevPageBtn.classList = 'p-4';

                        if (result.leaves.prev) {
                            prevPageBtn.onclick = () => GetEmpLeaves(result.leaves.prev);
                        } else {
                            prevPageBtn.disabled = true;
                        }

                        let nextPageBtn = document.createElement('button');
                        nextPageBtn.innerText = 'next';
                        nextPageBtn.classList = 'p-4';

                        if (result.leaves.next) {
                            nextPageBtn.onclick = () => GetEmpLeaves(result.leaves.next);
                        } else {
                            nextPageBtn.disabled = true;
                        }

                        let jumpToLastPageBtn = document.createElement('button');
                        jumpToLastPageBtn.innerText = '>>';
                        jumpToLastPageBtn.onclick = () => GetEmpLeaves(result.leaves.last_page);

                        paginationContainer.append(jumpToFirstPageBtn, prevPageBtn);

                        let limit = Math.ceil(result.leaves.current_page / 3) * 3;

                        if (result.leaves.current_page % 3 === 0) {
                            limit += 3;
                        }

                        if (limit > result.leaves.last_page) {
                            limit = result.leaves.last_page;
                        }

                        for (let i = 1; i <= limit; i++) {
                            let pageBtn = document.createElement('button');
                            pageBtn.innerText = i;
                            pageBtn.className = 'p-2';

                            if (i === result.leaves.current_page) {
                                pageBtn.className = 'p-2 bg-blue-800 text-white';
                            }

                            pageBtn.onclick = () => GetEmpLeaves(i);
                            paginationContainer.appendChild(pageBtn);
                        }

                        if (limit < result.leaves.last_page) {
                            let dots = document.createElement('button');
                            dots.innerText = '...';
                            dots.className = 'p-2';
                            dots.disabled = true;
                            paginationContainer.appendChild(dots);
                        }

                        paginationContainer.append(nextPageBtn, jumpToLastPageBtn);
                        // Pagination ends
                    }
                } catch (e) {
                    toastr.error(e);
                    console.error(e);
                }
            }

            document.addEventListener('DOMContentLoaded', () => GetEmpLeaves(1));
        </script>
        {{-- /Get Leaves --}}

    </div>

</body>

</html>
