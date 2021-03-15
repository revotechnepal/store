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
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SentMailController;
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
    Route::put('deletescreenshot/{id}', [ProjectController::class, 'deletescreenshot'])->name('deletescreenshot');
    Route::post('addmoreimages/{id}', [ProjectController::class, 'addmoreimages'])->name('addmoreimages');
    Route::resource('payment', PaymentController::class);
    Route::resource('client', ClientController::class);
    Route::get('generatereport', [ThirdPartyController::class, 'generatereport'])->name('generatereport');
    Route::get('paydues/{id}/{date}', [ThirdPartyController::class, 'paydues'])->name('paydues');
    Route::post('cleardues/{id}', [ThirdPartyController::class, 'cleardues'])->name('cleardues');
    Route::resource('thirdparty', ThirdPartyController::class);
    Route::resource('user', UserController::class);
    Route::resource('purchaserecord', PurchaseRecordController::class);
    Route::resource('sentmails', SentMailController::class);
    Route::post('updateexit', [AttendanceController::class, 'updateexit'])->name('updateexit');
    Route::get('report', [AttendanceController::class, 'report'])->name('report');
    Route::get('reportgenerator', [AttendanceController::class, 'reportgenerator'])->name('reportgenerator');
    Route::resource('attendance', AttendanceController::class);
    Route::get('salaryreport', [SalaryPaymentController::class, 'salaryreport'])->name('salaryreport');
    Route::get('salaryreportgenerate', [SalaryPaymentController::class, 'salaryreportgenerate'])->name('salaryreportgenerate');
    Route::resource('salarypayment', SalaryPaymentController::class);
    Route::get('paymentstaff/{id}', [SalaryPaymentController::class, 'paymentstaff'])->name('paymentstaff');
    Route::resource('category', CategoryController::class);
    Route::resource('mail', SendEmailController::class);
    Route::post('customerEmail', [SendEmailController::class, 'customerEmail'])->name('customer.email');
    Route::resource('rolepermission', RolePermissionController::class);
    Route::put('position/disable/{id}', [PositionController::class, 'disableposition'])->name('position.disable');
    Route::put('position/enable/{id}', [PositionController::class, 'enableposition'])->name('position.enable');
    Route::put('staff/disable/{id}', [StaffController::class, 'disablestaff'])->name('staff.disable');
    Route::put('staff/enable/{id}', [StaffController::class, 'enablestaff'])->name('staff.enable');
});


// Route::get('pdf/preview/{id}', [PDFController::class, 'preview'])->name('pdf.preview');
Route::get('pdf/generate/{id}', [PDFController::class, 'generatePDF'])->name('pdf.generate');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
