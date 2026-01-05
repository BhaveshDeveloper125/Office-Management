<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overtime or Forgot Checkout</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <x-link />
</head>

<body class="h-screen w-screen flex">
    <x-employee-menu />
    <div class="flex-1">
        <x-employee-page-header />

        <table>
            <tr>
                <th>Sr no</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>CheckIn</th>
                <th colspan="2">CheckOut</th>
            </tr>
            <tbody id="checkout">

            </tbody>
        </table>

    </div>

    <script>
        let formEventListenersAttached = false;

        document.addEventListener('DOMContentLoaded', FetchData);

        async function FetchData() {
            console.log('FetchData called');
            try {
                const response = await fetch('/late_checkouts');
                const result = await response.json();

                if (!response.ok) {
                    toastr.error(result.error);
                    console.error(result.error);
                } else {
                    let checkout = document.querySelector('#checkout')
                    checkout.innerHTML = '';
                    let srno = 1;
                    result.attendance.forEach(i => {
                        let currentSrno = srno++;
                        let tr = document.createElement('tr');
                        tr.innerHTML = `
                        <td>${currentSrno}</td>
                        <td>${i.user.name}</td>
                        <td>${i.user.email}</td>
                        <td>${i.user.mobile}</td>
                        <td>${new Date(i.checkin).toLocaleString('en-GB', { hour12: true })}</td>
                        <td>
                            <form action="/after_checkouts" method="post" id="lateCheckoutForm${currentSrno}">
                                @csrf
                                <input type="hidden" name="id" value=${i.id} id="${i.id}" required />
                                <input type="datetime-local" name="checkout" id="${currentSrno}checkout" required />
                                <input type="submit" value="Checkout">
                            </form>
                        </td>
                    `;
                        checkout.appendChild(tr);
                    });

                    // Only attach event listeners once, not on every refresh
                    if (!formEventListenersAttached) {
                        attachFormEventListeners(result.attendance);
                        formEventListenersAttached = true;
                    }

                }

            } catch (e) {
                toastr.error(e);
                console.error(e);
            }
        }

        function attachFormEventListeners(attendanceData) {
            attendanceData.forEach((item, index) => {
                const formId = `lateCheckoutForm${index + 1}`;
                const formElement = document.querySelector(`#${formId}`);
                if (formElement) {
                    formElement.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        try {
                            const response = await fetch('/after_checkouts', {
                                method: "POST",
                                body: new FormData(e.target)
                            });

                            const result = await response.json();

                            if (response.ok) {
                                console.log('Form submitted successfully, refreshing data...');
                                formEventListenersAttached = false;
                                FetchData();
                                toastr.success(result.success);
                            } else {
                                toastr.error(result.error);
                            }

                        } catch (e) {
                            toastr.error(e);
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>
