<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;



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

    Route::middleware(["guest:admin,patient,doctor,ray_employee,laboratorie_employee"])->group(function () {
        Route::get('/login', [SiteController::class, 'login'])->name('login');
    });


});





?>
