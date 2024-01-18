<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Services\LaboratoryEmployee\DashboardServices;
use App\Http\Controllers\LaboratorieEmploye\Invoice\InvoiceController;


/*
|--------------------------------------------------------------------------
| Web Routes
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
//------------------------------Auth laboratoryEmployee -------------------------------------//
require __DIR__.'/auth.php';
//------------------------------End Auth laboratoryEmployee ---------------------------------//

Route::middleware(["auth:laboratorie_employee" , "verified"])->group(function () {
    //------------------------------Dashboard laboratoryEmployee --------------------------------//
    Route::get('/dashboard' , [SiteController::class , 'laboratoryEmployeeDashboard'])->name('LaboratoryEmployee.dashboard');
    //------------------------------End Dashboard laboratoryEmployee ----------------------------//

    Route::resource('laboratory-employee-invoice' , InvoiceController::class);
    Route::get('laboratory-invoice-completed' , [InvoiceController::class , 'completedInvoices'])->name('laboratory-employee.invoice.completed');
    Route::get('laboratory-invoice-patient/{id}' , [InvoiceController::class , 'viewLaboratory'])->name('laboratory-employee.invoice.patient');

});

});




