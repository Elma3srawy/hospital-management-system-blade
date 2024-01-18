<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Doctor\Ray\RayController;
use App\Services\ProfileImage\ProfileImageServices;
use App\Http\Controllers\Doctor\Invoice\InvoiceController;
use App\Http\Controllers\Doctor\Diagnostic\DiagnosticController;
use App\Http\Controllers\Doctor\Laboratory\LaboratoryController;

/*
|--------------------------------------------------------------------------
| Doctor Routes
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

require __DIR__.'/auth.php';



Route::middleware(['auth:doctor' ,'verified'])->group(function(){


    Route::get('/dashboard' , [SiteController::class , 'doctorDashboard'])->name('doctor.dashboard');

    Route::controller(InvoiceController::class)->group(function(){
        Route::get('/invoice/pending' , 'pending')->name('doctor.invoice.pending');
        Route::get('/invoice/review' , 'review')->name('doctor.invoice.review');
        Route::get('/invoice/completed' , 'completed')->name('doctor.invoice.completed');
        Route::get('/invoice/ray/show/{id}' , 'show')->name('doctor.invoice.show');
        Route::get('/invoice/show/laboratory/{id}' , 'showLaboratory')->name('doctor.invoice.show.laboratory');
        Route::get('/patient/details/{id}' , 'patientDetails')->name('doctor.patient.details');
    });

    Route::controller(DiagnosticController::class)->group(function(){
        Route::post('/diagnostic/store' , 'store')->name('doctor.diagnostic.store');
        Route::get('/diagnostic/show' , 'show')->name('doctor.diagnostic.show');
        Route::post('/review/store' , 'addReview')->name('doctor.review.store');
    });

    Route::controller(RayController::class)->group(function(){
        Route::post('/ray/store' , 'store')->name('doctor.ray.store');
        Route::put('/ray/update' , 'update')->name('doctor.ray.update');
        Route::delete('/ray/delete' , 'destroy')->name('doctor.ray.destroy');
    });

    Route::controller(LaboratoryController::class)->group(function(){
        Route::post('/laboratory/store' , 'store')->name('doctor.laboratory.store');
        Route::put('/laboratory/update' , 'update')->name('doctor.laboratory.update');
        Route::delete('/laboratory/delete' , 'destroy')->name('doctor.laboratory.destroy');
    });






});




});




Route::get('/test', function(){
    // return (new ProfileImageServices)->ProfileImage();
});
