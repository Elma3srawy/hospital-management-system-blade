<?php

use Livewire\Livewire;
use App\Livewire\SingleInvoice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Services\Admin\DashboardServices;
use App\Http\Controllers\Admin\Doctor\DoctorController;
use App\Http\Controllers\Admin\Patient\PatientContoller;
use App\Http\Controllers\Admin\Section\SectionController;
use App\Http\Controllers\Admin\Service\ServiceController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\Ambulance\AmbulanceController;
use App\Http\Controllers\Admin\Insurance\InsuranceController;
use App\Http\Controllers\Admin\RayEmployee\RayEmployeeController;
use App\Http\Controllers\Admin\PaymentAccount\PaymentAccountController;
use App\Http\Controllers\Admin\ReceiptAccount\ReceiptAccountController;
use App\Http\Controllers\Admin\LaboratoryEmployee\LaboratoryEmployeeController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(
[
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle);
});

//------------------------------Auth Admin -------------------------------------//
require __DIR__.'/auth.php';

//------------------------------End Auth Admin ---------------------------------//




Route::middleware(["auth:admin" , "verified"])->group(function () {

    //------------------------------Dashboard Admin --------------------------------//
        Route::get('/dashboard' , [SiteController::class , 'adminDashboard'])->name('admin.dashboard');
    //------------------------------End Dashboard Admin -----------------------------//


    //--------------------------------- Section Admin -------------------------------//
        Route::resource("/section", SectionController::class);
    //------------------------------End Section Admin -------------------------------//

    //----------------------------- Doctor Admin ------------------------------------//
        Route::resource("/doctor", DoctorController::class);
        Route::post("/doctor/update-password", [DoctorController::class, 'ChangePassword'])->name('admin.change.doctor.password');
        Route::post("/doctor/change-status", [DoctorController::class, 'ChangeStatus'])->name('admin.change.doctor.status');
    //------------------------------End Doctor --------------------------------------//

    //-------------------------------- Services -------------------------------------//
         Route::resource("/service", ServiceController::class);
    //------------------------------End Services ------------------------------------//

    //-------------------------------- Insurance -------------------------------------//
        Route::resource("/insurance", InsuranceController::class);
    //------------------------------End Insurance ------------------------------------//

    //-------------------------------- Ambulances -------------------------------------//
        Route::resource("/ambulance", AmbulanceController::class);
    //------------------------------End Ambulances ------------------------------------//

    //-------------------------------- Patients -------------------------------------//
        Route::resource("/patient", PatientContoller::class);
    //------------------------------End Patients ------------------------------------//

    //-------------------------------- Single Invoice -------------------------------------//
        Route::get("/single-invoice", SingleInvoice::class)->name('admin.single.invoice');
        Route::get("/single-invoice-print/{id}", [SingleInvoice::class ,'print'])->name('admin.single.invoice.print');
    //------------------------------End Single Invoice ------------------------------------//

    //-------------------------------- Receipt Account -------------------------------------//
        Route::resource("/receipt-account", ReceiptAccountController::class);
        Route::get('receipt-account-print/{id}' ,[ReceiptAccountController::class , 'print'])->name('admin.receipt.account.print');
    //------------------------------End Receipt Account ------------------------------------//

    //-------------------------------- Payment Account -------------------------------------//
        Route::resource("/payment-account", PaymentAccountController::class);
        Route::get('payment-account-print/{id}' ,[PaymentAccountController::class , 'print'])->name('admin.payment.account.print');
    //------------------------------End Payment Account ------------------------------------//

    //------------------------------ RayEmployee route ------------------------------------//
        Route::resource('ray-employee', RayEmployeeController::class);
    //------------------------------ End RayEmployee route ------------------------------------//

    //------------------------------ laboratoryEmployee route ------------------------------------//
        Route::resource('laboratory-employee', LaboratoryEmployeeController::class);
    //------------------------------ End laboratoryEmployee route ------------------------------------//

});


});

