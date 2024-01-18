<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\patient\Dashboard\DashboardController;


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
//------------------------------Auth Patient -------------------------------------//
require __DIR__.'/auth.php';
//------------------------------End Auth Patient ---------------------------------//

Route::middleware(["auth:patient" , "verified"])->group(function () {

    //------------------------------Dashboard Patient --------------------------------//
        Route::get('/dashboard' ,[SiteController::class , 'patientDashboard'])->name('patient.dashboard');
    //------------------------------End Dashboard Patient ----------------------------//

    Route::controller(DashboardController::class)->group(function(){
        Route::get('invoices', 'invoices')->name('patient.invoices');
        Route::get('laboratories', 'laboratories')->name('patient.laboratories');
        Route::get('view_laboratories/{id}', 'viewLaboratories')->name('patient.laboratories.view');
        Route::get('rays', 'rays')->name('patient.rays');
        Route::get('view_rays/{id}','viewRays')->name('patient.rays.view');
        Route::get('payments', 'payments')->name('patient.payments');
    });

});
});


