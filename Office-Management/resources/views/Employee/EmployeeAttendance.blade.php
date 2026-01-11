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
        <h1>Attendance History</h1>

        <br>

        <form id="EmpFilterHistoryForm">
            @csrf
            <input type="date" name="from" id="from" required>
            <input type="date" name="to" id="to">
            <input type="submit" value="Fetch History">
        </form>

        <br>

        <table class="hidden">
            <thead class="">
                <tr>
                    <th class="border border-slate-300 p-2">Sr no</th>
                    <th class="border border-slate-300 p-2">Date</th>
                    <th class="border border-slate-300 p-2">Day</th>
                    <th class="border border-slate-300 p-2">Check In</th>
                    <th class="border border-slate-300 p-2">Check Out</th>
                    <th class="border border-slate-300 p-2">Tag</th>
                    <th class="border border-slate-300 p-2">Worked Hours</th>
                    <th class="border border-slate-300 p-2">Working Hours</th>
                    <th class="border border-slate-300 p-2">Working Time From</th>
                    <th class="border border-slate-300 p-2">Working Time To</th>
                </tr>
            </thead>
            <tbody id="EmpHistoryFilter"></tbody>
        </table>
        <div id="paginationContainer"></div>

        <br>

        <table class="w-full border-collapse border border-slate-400 text-left">
            <thead class="">
                <tr>
                    <th class="border border-slate-300 p-2">Sr no</th>
                    <th class="border border-slate-300 p-2">Date</th>
                    <th class="border border-slate-300 p-2">Day</th>
                    <th class="border border-slate-300 p-2">Check In</th>
                    <th class="border border-slate-300 p-2">Check Out</th>
                    <th class="border border-slate-300 p-2">Tag</th>
                    <th class="border border-slate-300 p-2">Worked Hours</th>
                    <th class="border border-slate-300 p-2">Working Hours</th>
                    <th class="border border-slate-300 p-2">Working Time From</th>
                    <th class="border border-slate-300 p-2">Working Time To</th>
                </tr>
            </thead>
            <tbody id="EmpHistory"></tbody>
        </table>
    </div>

    {{-- Filter History --}}
    <script>
        document.querySelector('#EmpFilterHistoryForm').addEventListener('submit', (e) => {
            e.preventDefault();
            EmpFilterHistoryForm(1, true);
        });

        async function EmpFilterHistoryForm(page, isFormSubmission = false) {
            try {
                let currentPage = 1;

                page = page || currentPage;
                currentPage = page;

                const response = await fetch(`/filter_emp_history?page=${page}`, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: new FormData(document.querySelector('#EmpFilterHistoryForm')),
                });
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result.error);
                    console.error(result.error);
                } else {

                    let EmpHistoryFilter = document.querySelector('#EmpHistoryFilter');
                    EmpHistoryFilter.innerHTML = '';
                    EmpHistoryFilter.parentElement.classList.remove('hidden');

                    let index = 0;

                    result.attendance.data.forEach(i => {
                        let tr = document.createElement('tr');
                        let tag;

                        if (i.checkin > i.user.working_from) {
                            tag = 'Late';
                        } else if (i.checkin < i.user.working_from) {
                            tag = 'Early';
                        } else {
                            tag = '-';
                        }


                        tr.innerHTML = `
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${result.attendance.from + index}</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${new Date(i.created_at).toLocaleDateString('en-GB')}</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${new Date(i.created_at).toLocaleDateString('en-GB' , {weekday:'short'})}</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${new Date(i.checkin).toLocaleTimeString('en-GB')}</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.checkout !== null ?  new Date(i.checkout).toLocaleTimeString('en-GB') : '-'}</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${tag}</td>
                                <td class="border border-slate-300 p-4 text-center text-gray-500"> ${(i.hours || '0:0:0').split(':').slice(0,2).map((v, index) => `${parseInt(v)} ${index === 0 ? 'hr' : 'min'} `).join(' ')} </td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.user.hours} hr</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.user.working_from}</td>
                                <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.user.working_to}</td>
                            `;
                        EmpHistoryFilter.appendChild(tr);
                        index++;
                    });

                    if (isFormSubmission) {
                        toastr.success('Success');
                    }

                    // Pagination start
                    let paginationContainer = document.querySelector('#paginationContainer');
                    paginationContainer.innerHTML = '';

                    if (result.attendance.total > result.attendance.per_page) {

                        let jumpToFirstPageBtn = document.createElement('button');
                        jumpToFirstPageBtn.innerText = '<<';
                        jumpToFirstPageBtn.classList = 'p-4';
                        jumpToFirstPageBtn.onclick = () => EmpFilterHistoryForm(1);

                        let prevPageBtn = document.createElement('button');
                        prevPageBtn.innerText = 'prev';
                        prevPageBtn.classList = 'p-4';

                        if (result.attendance.prev_page_url) {
                            prevPageBtn.onclick = () => EmpFilterHistoryForm(result.attendance.current_page - 1);
                        } else {
                            prevPageBtn.disabled = true;
                        }

                        let nextPageBtn = document.createElement('button');
                        nextPageBtn.innerText = 'next';
                        nextPageBtn.classList = 'p-4';

                        if (result.attendance.next_page_url) {
                            nextPageBtn.onclick = () => EmpFilterHistoryForm(result.attendance.current_page + 1);
                        } else {
                            nextPageBtn.disabled = true;
                        }

                        let jumpToLastPageBtn = document.createElement('button');
                        jumpToLastPageBtn.innerText = '>>';
                        jumpToLastPageBtn.classList = 'p-4';
                        jumpToLastPageBtn.onclick = () => EmpFilterHistoryForm(result.attendance.last_page);

                        paginationContainer.append(jumpToFirstPageBtn, prevPageBtn);

                        let start = Math.max(1, result.attendance.current_page - 1);
                        let end = Math.min(start + 2, result.attendance.last_page);

                        if (result.attendance.current_page === result.attendance.last_page) {
                            start = Math.max(1, result.attendance.last_page - 2);
                            end = result.attendance.last_page;
                        }

                        for (let i = start; i <= end; i++) {
                            let pageBtn = document.createElement('button');
                            pageBtn.innerText = i;
                            pageBtn.className = 'p-2';

                            if (i === result.attendance.current_page) {
                                pageBtn.className = 'p-2 bg-blue-800 text-white';
                            }

                            pageBtn.onclick = () => EmpFilterHistoryForm(i);
                            paginationContainer.appendChild(pageBtn);
                        }

                        paginationContainer.append(nextPageBtn, jumpToLastPageBtn);
                    }
                    // Pagination ends
                }

            } catch (e) {
                toastr.error(e);
                console.error(e);
            }
        }
    </script>
    {{-- /Filter History --}}


    {{-- Current Month Attendance History --}}
    <script>
        document.addEventListener('DOMContentLoaded', async () => {

            let index = 0;

            try {
                const response = await fetch('/emp/history');
                const result = await response.json();

                if (response.ok) {

                    let EmpHistory = document.querySelector('#EmpHistory');
                    EmpHistory.innerHTML = '';

                    result.History.forEach(i => {
                        index++;
                        let tr = document.createElement('tr');

                        let tag = '';
                        const checkinDate = new Date(i.checkin);
                        const checkinTotalMinutes = (checkinDate.getHours() * 60) + checkinDate
                            .getMinutes();

                        const [h, m] = i.user.working_from.split(':');
                        const workTotalMinutes = (parseInt(h) * 60) + parseInt(m);

                        if (checkinTotalMinutes > workTotalMinutes) {
                            tag = `<span class="bg-yellow-500 text-red-500 m-2">Late</span>`;
                        }

                        if (i.checkout) {

                            const checkoutDate = new Date(i.checkout);
                            const checkoutTotalMinutes = (checkoutDate.getHours() * 60) + checkoutDate
                                .getMinutes();

                            const [h_end, m_end] = i.user.working_to.split(':');
                            const workEndTotalMinutes = (parseInt(h_end) * 60) + parseInt(m_end);

                            if (checkoutTotalMinutes < workEndTotalMinutes) {
                                tag +=
                                    `<span class="bg-yellow-500 text-red-500 m-2">Early leave</span>`;
                            }
                        }

                        if (tag === '') {
                            tag = '-';
                        }

                        tr.innerHTML = `
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${index}</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${new Date(i.created_at).toLocaleDateString('en-GB')}</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${new Date(i.created_at).toLocaleDateString('en-GB' , {weekday:'short'})}</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${new Date(i.checkin).toLocaleTimeString('en-GB')}</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.checkout !== null ?  new Date(i.checkout).toLocaleTimeString('en-GB') : '-'}</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${tag}</td>
                            <td class="border border-slate-300 p-4 text-center ${parseInt(i.hours) < 9 ? 'text-red-500' : 'text-gray-500'}"> 
                                ${(i.hours || '0:0:0').split(':').slice(0,2).map((v, index) => `${parseInt(v)} ${index === 0 ? 'hr' : 'min'} `).join(' ')} 
                            </td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.user.hours} hr</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.user.working_from}</td>
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${i.user.working_to}</td>
                        `;
                        EmpHistory.appendChild(tr);
                    });

                } else {
                    toastr.error(result.error);
                    console.error(result.error);
                }
            } catch (e) {
                toastr.error(e);
            }

        });
    </script>
    {{-- /Current Month Attendance History --}}

</body>

</html>
