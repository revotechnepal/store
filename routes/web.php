<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PurchaseRecordController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ThirdPartyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/dashboard', function () {
//     return view('backend.index');
// });

Route::group(['prefix'=>'admin','as'=>'admin.','middleware' => ['auth', 'roles']], function(){
    Route::resource('position', PositionController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('visitor', VisitorController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('client', ClientController::class);
    Route::resource('thirdparty', ThirdPartyController::class);
    Route::resource('user', UserController::class);
    Route::resource('purchaserecord', PurchaseRecordController::class);
    Route::get('report', [AttendanceController::class, 'report'])->name('report');
    Route::get('reportgenerator', [AttendanceController::class, 'reportgenerator'])->name('reportgenerator');
    Route::resource('attendance', AttendanceController::class);
    Route::get('staffmail', [MailController::class, 'staffmail'])->name('staffmail');
    Route::get('editStaffMessage', [MailController::class, 'editStaffMessage'])->name('editStaffMessage');
    Route::put('staffmessage/update', [MailController::class, 'updatestaffmessage'])->name('staff.message.update');
    Route::get('editClientMessage', [MailController::class, 'editClientMessage'])->name('editClientMessage');
    Route::put('clientmessage/update', [MailController::class, 'updateclientmessage'])->name('client.message.update');
    Route::get('editThirdMessage', [MailController::class, 'editThirdMessage'])->name('editThirdMessage');
    Route::put('thirdmessage/update', [MailController::class, 'updatethirdmessage'])->name('third.message.update');
    Route::get('customerEmail', [MailController::class, 'customerEmail'])->name('customer.email');
    Route::get('clientEmail', [MailController::class, 'clientEmail'])->name('client.email');
    Route::get('thirdpartyEmail', [MailController::class, 'thirdpartyEmail'])->name('thirdparty.email');
    Route::get('salaryreport', [SalaryPaymentController::class, 'salaryreport'])->name('salaryreport');
    Route::get('salaryreportgenerate', [SalaryPaymentController::class, 'salaryreportgenerate'])->name('salaryreportgenerate');
    Route::resource('salarypayment', SalaryPaymentController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('rolepermission', RolePermissionController::class);
    Route::put('position/disable/{id}', [PositionController::class, 'disableposition'])->name('position.disable');
    Route::put('position/enable/{id}', [PositionController::class, 'enableposition'])->name('position.enable');
});


// Route::get('pdf/preview/{id}', [PDFController::class, 'preview'])->name('pdf.preview');
Route::get('pdf/generate/{id}', [PDFController::class, 'generatePDF'])->name('pdf.generate');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

