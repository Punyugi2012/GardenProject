<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('/employees', 'EmployeeController');
Route::resource('/attendances', 'AttendanceController');
Route::resource('/leaves', 'LeaveController');
Route::resource('/salaries', 'SalaryController');
Route::resource('/items', 'ItemController');
Auth::routes();

