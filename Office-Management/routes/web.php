<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\Usercontroller;
use App\Http\Middleware\AuthcheckMiddleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [Usercontroller::class, 'Login'])->name('login');

// Route::middleware(AuthcheckMiddleware::class)->group(function () {
Route::post('/registration', [Usercontroller::class, 'Register'])->name('register');
Route::view('/admin', 'Admin.AdminHomePage');
Route::view('/add_emp', 'Admin.AddEmployees');

Route::get('/roles', [RoleController::class, 'GetRoles'])->name('roles');
// });



Route::view('/loginpage', 'Login')->name('LoginPage');
