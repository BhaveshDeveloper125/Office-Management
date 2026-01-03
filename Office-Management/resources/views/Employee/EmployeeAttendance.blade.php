<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance</title>
    <x-link />
</head>

<body class="h-screen w-screen flex">
    <x-employee-menu />
    <div class="flex-1">
        <h1>Attendance History</h1>
        <table class="w-full border-collapse border border-slate-400 text-left">
            <thead class="bg-slate-50">
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

                    console.log(result);
                } else {
                    toastr.error(result.error);
                    console.log(result.error);
                }
            } catch (e) {
                toastr.error(e);
            }

        });
    </script>
    {{-- /Current Month Attendance History --}}

</body>

</html>
