<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeHomePageController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\WeeklyHolidayController;
use App\Http\Middleware\AuthcheckMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect('/admin');
        } else {
            return view('Employee.EmployeeHome');
        }
    }
    return redirect()->route('Login Page');
});

Route::view('/login_page', 'Login')->name('Login Page');
Route::post('/login', [Usercontroller::class, 'Login'])->name('login');

Route::middleware(AuthcheckMiddleware::class)->group(function () {

    Route::get('/roles', [RoleController::class, 'GetRoles'])->name('roles');
    Route::get('/emp_list', [Usercontroller::class, 'GetEmpList'])->name('emp_list');
    Route::get('/weekend', [WeeklyHolidayController::class, 'GetWeekends']);
    Route::get('/holidays', [HolidayController::class, 'GetHoliday']);
    Route::get('/emp/history', [AttendanceController::class, 'EmpHistory']);
    Route::get('/current_month_attendace_summary', [AttendanceController::class, 'CurrentMonthAttendanceReport']);
    Route::get('/current_month_holiday', [HolidayController::class, 'GetCurrentMonthHolidayCount']);
    Route::get('/current_month_workin_days', [EmployeeHomePageController::class, 'CurrentMonthWorkingDays']);
    Route::get('/late_checkouts', [AttendanceController::class, 'LateCheckOutList']);
    Route::get('/getempleave', [LeaveController::class, 'GetEmpLeaves'])->name('GetEmpLeaves');
    Route::get('/employee_attendance_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_late_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_early_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_absent_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_overtime_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_holiday_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_workingdays_data',[EmployeeHomePageController::class, 'GetAttendanceData']);
    Route::get('/employee_remainingworkingdays_data',[EmployeeHomePageController::class, 'GetAttendanceData']);

    Route::get('/edit_employee/{user}', function (User $user) {
        return view('Admin.EditEmployee', ['user' => $user]);
    });

    Route::get('/edit_password/{user}', function (User $user) {
        return view('Admin.ChangePassword', ['user' => $user]);
    });


    Route::post('/registration', [Usercontroller::class, 'Register'])->name('register');
    Route::post('/filter_employee', [Usercontroller::class, 'FilterEmpList'])->name('FilterEmployee');
    Route::post('/search_employee', [Usercontroller::class, 'SearchEmp'])->name('SearchEmployee');
    Route::post('/add_weekend', [WeeklyHolidayController::class, 'AddWeekend']);
    Route::post('/set_holiday', [HolidayController::class, 'AddHoliday']);
    Route::post('/checkin', [AttendanceController::class, 'CheckIn'])->name('CheckIn');
    Route::post('/checkout', [AttendanceController::class, 'CheckOut'])->name('CheckOut');
    Route::post('/after_checkouts', [AttendanceController::class, 'AfterCheckouts'])->name('AfterCheckouts');
    Route::post('/filter_emp_history', [AttendanceController::class, 'FilterHistory']);
    Route::post('/create_leave', [LeaveController::class, 'CreateLeave'])->name('CreateLeave');
    Route::post('/attendance_data', [EmployeeHomePageController::class, 'GetAttendanceData']);

    Route::post('/logout', [Usercontroller::class, 'Logout'])->name('logout');

    Route::put('/update_emp_details', [Usercontroller::class, 'UpdateEmp'])->name('UpdateEmpDetails');
    Route::put('/change_password', [Usercontroller::class, 'ChangePassword'])->name('ChangePassword');
    Route::put('/update_user', [Usercontroller::class, 'UpdateUser'])->name('UpdateUser');

    Route::delete('/delete_employee', [Usercontroller::class, 'DeleteEmployee'])->name('DeleteEmployee');
    Route::delete('/remove_weekend', [WeeklyHolidayController::class, 'RemoveWeekends']);
    Route::delete('/remove_holiday', [HolidayController::class, 'RemoveHoliday']);

    // Route::view('/admin', 'Admin.AdminHomePage')->middleware('role:Super Admin');
    Route::view('/admin', 'Admin.AdminHomePage');
    Route::view('/add_emp', 'Admin.AddEmployees');
    Route::view('/emp_details', 'Admin.EmployeeDetails');
    Route::view('/manage_holiday', 'Admin.HolidayManagement');
    Route::view('/attendance', 'Employee.Attendance');
    Route::view('/emp_attendance', 'Employee.EmployeeAttendance');
    Route::view('/emp/profile', 'Employee.Profile');
    Route::view('/emp_leave', 'Employee.AskLeave');
    Route::view('/emp_attendance_data', 'Employee.EmployeeAttendanceData')->name('EmployeeAttendanceData');
    Route::view('/emp_late_data', 'Employee.Late')->name('EmployeeLateData');
    Route::view('/emp_early_data', 'Employee.Early')->name('EmployeeEarlyData');
    Route::view('/emp_absent_data', 'Employee.Absent')->name('EmployeeAbsentData');
    Route::view('/emp_overtime_data', 'Employee.Overtime')->name('EmployeeOvertimeData');
    Route::view('/emp_holiday_data', 'Employee.Holiday')->name('EmployeeHolidayData');
    Route::view('/emp_workingdays_data', 'Employee.WorkingDay')->name('EmployeeWorkingDaysData');
    Route::view('/emp_remainingworkingdays_data', 'Employee.RemainingDay')->name('EmployeeRemainingWorkingDaysData');
});
