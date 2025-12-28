<?php

use App\Http\Controllers\HolidayController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\WeeklyHolidayController;
use App\Http\Middleware\AuthcheckMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [Usercontroller::class, 'Login'])->name('login');

// Route::middleware(AuthcheckMiddleware::class)->group(function () {
Route::view('/admin', 'Admin.AdminHomePage');
Route::view('/add_emp', 'Admin.AddEmployees');
Route::view('/emp_details', 'Admin.EmployeeDetails');
Route::view('/manage_holiday', 'Admin.HolidayManagement');

Route::get('/roles', [RoleController::class, 'GetRoles'])->name('roles');
Route::get('/emp_list', [Usercontroller::class, 'GetEmpList'])->name('emp_list');
Route::get('/weekend', [WeeklyHolidayController::class, 'GetWeekends']);
Route::get('/holidays', [HolidayController::class, 'GetHoliday']);

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

Route::put('/update_emp_details', [Usercontroller::class, 'UpdateEmp'])->name('UpdateEmpDetails');
Route::put('/change_password', [Usercontroller::class, 'ChangePassword'])->name('ChangePassword');

Route::delete('/delete_employee', [Usercontroller::class, 'DeleteEmployee'])->name('DeleteEmployee');
Route::delete('/remove_weekend', [WeeklyHolidayController::class, 'RemoveWeekends']);

// });



Route::view('/loginpage', 'Login')->name('LoginPage');
