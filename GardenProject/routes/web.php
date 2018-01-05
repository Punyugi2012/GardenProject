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
Route::resource('/payments', 'PaymentController');
Route::post('/payments_detail/payment/{idPayment}', 'PaymentDetailController@store');
Route::delete('/payments_detail/{idPaymentDetail}/payment/{idPayment}', 'PaymentDetailController@destroy');
Route::get('/edit-payments_detail/{idPaymentDetail}/payment/{idPayment}', 'PaymentDetailController@edit');
Route::put('/edit-payments_detail/{idPaymentDetail}/payment/{idPayment}', 'PaymentDetailController@update');
Route::resource('/claims', 'ClaimController');
Route::post('/claims_detail/claim/{idClaim}', 'ClaimDetailController@store');
Route::delete('/claims_detail/{idClaimDetail}/claim/{idClaim}', 'ClaimDetailController@destroy');
Route::get('/edit-claims_detail/{idClaimDetail}/claim/{idClaim}', 'ClaimDetailController@edit');
Route::put('/edit-claims_detail/{idClaimDetail}/claim/{idClaim}', 'ClaimDetailController@update');
Route::resource('/receiptclaims', 'ReceiptClaimController');
Route::post('/receiptclaims_detail/receiptclaim/{idReceiptClaim}', 'ReceiptclaimDetailController@store');
Route::get('/edit-receiptclaims_detail/{idReceiptclaimDetail}/receiptclaim/{idReceiptClaim}', 'ReceiptclaimDetailController@edit');
Route::put('/edit-receiptclaims_detail/{idReceiptclaimDetail}/receiptclaim/{idReceiptClaim}', 'ReceiptclaimDetailController@update');
Route::delete('/receiptclaims_detail/{idReceiptclaimDetail}/receiptclaim/{idReceiptClaim}', 'ReceiptclaimDetailController@destroy');
Route::resource('/zones', 'ZoneController');
Route::resource('/assignmentTypes', 'AssignmentTypeController');
Route::resource('/assignments', 'AssignmentController');
Route::post('/assignments_detail/assignment/{idAssignment}', 'AssignmentDetailController@store');
Route::delete('/assignments_detail/{idAssignmentDetail}/assignment/{idAssignment}', 'AssignmentDetailController@destroy');
Auth::routes();

