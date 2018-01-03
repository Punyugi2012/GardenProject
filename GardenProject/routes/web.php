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
Route::resource('/shops', 'ShopController');
Route::resource('/purchases', 'PurchaseController');
Route::post('/purchases_detail/purchase/{idPurchase}', 'PurchaseDetailController@store');
Route::delete('/purchases_detail/{idPurchaseDetail}/purchase/{idPurchase}', 'PurchaseDetailController@destroy');
Route::get('/edit-purchases_detail/{idPurchaseDetail}/purchase/{idPurchase}', 'PurchaseDetailController@edit');
Route::put('/edit-purchases_detail/{idPurchaseDetail}/purchase/{idPurchase}', 'PurchaseDetailController@update');
Route::resource('/receipts', 'ReceiptController');
Route::post('/receipt_detail/receipt/{idReceipt}', 'ReceiptDetailController@store');
Route::delete('/receipt_detail/{idReceiptDetail}/receipt/{idReceipt}', 'ReceiptDetailController@destroy');
Route::get('/edit-receipt_detail/{idReceiptDetail}/receipt/{idReceipt}', 'ReceiptDetailController@edit');
Route::put('/edit-receipt_detail/{idReceiptDetail}/receipt/{idReceipt}', 'ReceiptDetailController@update');
Auth::routes();

