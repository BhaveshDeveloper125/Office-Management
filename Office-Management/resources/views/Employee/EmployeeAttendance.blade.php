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
            <tbody id="EmpHistory">
                <tr>
                    <td colspan="8" class="border border-slate-300 p-4 text-center text-gray-500">
                        Empty
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        document.querySelector('#EmpFilterHistoryForm').addEventListener('submit' , EmpFilterHistoryForm);

        async function EmpFilterHistoryForm(e) {
            e.preventDefault();
            try {
                const response = await fetch('/filter_emp_history',{
                    method:"POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: new FormData(e.target),
                });
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result.error);
                    console.error(result.error);
                }else{

                    let EmpHistoryFilter = document.querySelector('#EmpHistoryFilter');
                    EmpHistoryFilter.innerHTML='';
                    EmpHistoryFilter.parentElement.classList.remove('hidden');
                    
                    let index = 0;

                    result.attendance.data.forEach(i => {
                        index++;
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
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${index}</td>
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
                    });



                    toastr.success('Success');
                    console.log(result);
                }

            } catch (e) {
                toastr.error(e);
                console.error(e);
            }
        }

    </script>

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
                        let tag;

                        if (i.checkin > i.user.working_from) {
                            tag = 'Late';
                        } else if (i.checkin < i.user.working_from) {
                            tag = 'Early';
                        } else {
                            tag = '-';
                        }


                        tr.innerHTML = `
                            <td  class="border border-slate-300 p-4 text-center text-gray-500">${index}</td>
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
