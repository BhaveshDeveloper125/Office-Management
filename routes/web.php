<?php

use App\Http\Controllers\AdminHomePageController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeHomePageController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\UserLeaveController;
use App\Http\Controllers\WeeklyHolidayController;
use App\Http\Middleware\AuthcheckMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
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

Route::view('/forgot_password' , 'Employee.ForgotPassword')->name('forgotPassword');
Route::view('/login_page', 'Login')->name('Login Page');
Route::post('/login', [Usercontroller::class, 'Login'])->name('login');

Route::controller(ForgotPasswordController::class)->group(function(){
    Route::post('/reset_password' , 'CreateResetPasswordToken')->name('resetPassword');
    Route::post('/resetPassword', 'ResetPassword')->name('reset.password');
});

Route::get('/reset_password/{token}', function($token , Request $request){
    return view('ResetPasswordForm' , ['token' => $token , 'email' => $request->query('email')]);
});

Route::middleware(AuthcheckMiddleware::class)->group(function () {

    Route::get('/roles', [RoleController::class, 'GetRoles'])->name('roles');

    Route::controller(Usercontroller::class)->group(function(){
        Route::get('/emp_list', 'GetEmpList')->name('emp_list');
        Route::post('/registration', 'Register')->name('register');
        Route::post('/filter_employee', 'FilterEmpList')->name('FilterEmployee');
        Route::post('/search_employee', 'SearchEmp')->name('SearchEmployee');
        Route::post('/logout', 'Logout')->name('logout');
        Route::put('/update_emp_details', 'UpdateEmp')->name('UpdateEmpDetails');
        Route::put('/change_password', 'ChangePassword')->name('ChangePassword');
        Route::put('/update_user', 'UpdateUser')->name('UpdateUser');
        Route::delete('/delete_employee', 'DeleteEmployee')->name('DeleteEmployee');
    });
    
    Route::controller(WeeklyHolidayController::class)->group(function(){
        Route::get('/weekend', 'GetWeekends');
        Route::post('/add_weekend', 'AddWeekend');
        Route::delete('/remove_weekend', 'RemoveWeekends');
    });

    Route::controller(HolidayController::class)->group(function(){
        Route::get('/holidays', 'GetHoliday');
        Route::get('/current_month_holiday', 'GetCurrentMonthHolidayCount');
        Route::post('/set_holiday', 'AddHoliday');
        Route::delete('/remove_holiday', 'RemoveHoliday');
    });

    Route::controller(AttendanceController::class)->group(function(){
        Route::get('/emp/history', 'EmpHistory');
        Route::get('/current_month_attendace_summary', 'CurrentMonthAttendanceReport');
        Route::get('/late_checkouts', 'LateCheckOutList');
        Route::get('/emp_attendances','EmpAttendanceHistory');
        Route::get('/admin/daily_attendance','DailyAttendance');
        Route::post('/checkin', 'CheckIn')->name('CheckIn');
        Route::post('/checkout', 'CheckOut')->name('CheckOut');
        Route::post('/after_checkouts', 'AfterCheckouts')->name('AfterCheckouts');
        Route::post('/filter_emp_history', 'FilterHistory');
    });

    Route::controller(EmployeeHomePageController::class)->group(function(){
        Route::get('/current_month_workin_days', 'CurrentMonthWorkingDays');
        Route::get('/employee_attendance_data','GetAttendanceData');
        Route::get('/employee_late_data','GetAttendanceData');
        Route::get('/employee_early_data','GetAttendanceData');
        Route::get('/employee_absent_data','GetAttendanceData');
        Route::get('/employee_overtime_data','GetAttendanceData');
        Route::get('/employee_holiday_data','GetAttendanceData');
        Route::get('/employee_workingdays_data','GetAttendanceData');
        Route::get('/employee_remainingworkingdays_data','GetAttendanceData');
        Route::post('/attendance_data', 'GetAttendanceData');
    });

    Route::controller(LeaveController::class)->group(function(){
        Route::get('/getempleave', 'GetEmpLeaves')->name('GetEmpLeaves');
        Route::get('/admin/leaves/pending','GetAllLeaves');
        Route::get('/admin/leaves/approved','GetAllLeaves');
        Route::get('/admin/leaves/rejected','GetAllLeaves');
        Route::get('/admin/leaves/history','GetAllLeaves');
        Route::post('/create_leave', 'CreateLeave')->name('CreateLeave');
        Route::post('/admin/leavesaction', 'UpdateLeaveStatus')->name('UpdateLeaveStatus');
    });

    Route::controller(UserLeaveController::class)->group(function(){
        Route::get('/user_leave','GetLeaveRecord');
        Route::get('/applied_leave','AppliedLeaveList');
        Route::put('/apply_pay_on_previous_leave' , 'ApplyPayOnLeave');
        Route::put('/pay_leave_approve' , 'PayLeaveApprove');
        Route::put('/pay_leave_reject' , 'PayLeaveReject');
        // pay_leave_reject , pay_leave_approve
    });

    Route::get('/edit_employee/{user}', function (User $user) {
        return view('Admin.EditEmployee', ['user' => $user]);
    });

    Route::get('/edit_password/{user}', function (User $user) {
        return view('Admin.ChangePassword', ['user' => $user]);
    });
    
    
    Route::get('/admin_cards_data',[AdminHomePageController::class, 'Cards']);


    // Route::view('/admin', 'Admin.AdminHomePage')->middleware('role:Super Admin');
    Route::view('/admin', 'Admin.AdminHomePage');
    Route::view('/add_emp', 'Admin.AddEmployees');
    Route::view('/emp_details', 'Admin.EmployeeDetails');
    Route::view('/manage_holiday', 'Admin.HolidayManagement');
    Route::view('/attendance', 'Employee.Attendance');
    Route::view('/emp_attendance', 'Employee.EmployeeAttendance')->name('EmployeeAttendance');
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
    Route::view('/emp_leave_management', 'Admin.LeaveManagement')->name('EmployeeLeaveHistory');
    Route::view('/emp_daily_attendance', 'Admin.EmployeeDailyAttendance')->name('EmployeeDailyAttendance');
    Route::view('/admin/search_emp', 'Admin.SearchEmployee')->name('AdminSearchEmployee');
    Route::view('/pay_leave', 'Admin.PayLeave')->name('pay_leave');
});
