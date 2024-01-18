<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RayEmployee\Invoice\InvoiceController;


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
//------------------------------Auth RayEmployee -------------------------------------//
require __DIR__.'/auth.php';
//------------------------------End Auth RayEmployee ---------------------------------//

Route::middleware(["auth:ray_employee" , "verified"])->group(function () {

    //------------------------------Dashboard RayEmployee --------------------------------//
    Route::get('/dashboard' , [SiteController::class , 'rayEmployeeDashboard'])->name('ray_employee.dashboard');
    //------------------------------End Dashboard RayEmployee ----------------------------//


    Route::resource('ray-employee-invoice' , InvoiceController::class);
    Route::get('ray-invoice-completed' , [InvoiceController::class , 'completed_invoices'])->name('ray-employee.invoice.completed');
    Route::get('ray-invoice-patient/{id}' , [InvoiceController::class , 'view_rays'])->name('ray-employee.invoice.patient');

});

});


