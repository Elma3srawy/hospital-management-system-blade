<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaboratorieEmploye\Auth\PasswordController;
use App\Http\Controllers\Backend\Auth\VerifyEmailController;
use App\Http\Controllers\LaboratorieEmploye\Auth\NewPasswordController;
use App\Http\Controllers\LaboratorieEmploye\Auth\RegisteredUserController;
use App\Http\Controllers\LaboratorieEmploye\Auth\PasswordResetLinkController;
use App\Http\Controllers\LaboratorieEmploye\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Backend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Backend\Auth\EmailVerificationNotificationController;


Route::middleware('guest:admin,patient,doctor,ray_employee,laboratorie_employee')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('laboratorie_employee.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('laboratorie_employee.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('laboratorie_employee.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('laboratorie_employee.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('laboratorie_employee.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('laboratorie_employee.password.store');
});

Route::middleware('auth:laboratorie_employee')->group(function () {
    Route::get('laboratorie_employee.verify-email', EmailVerificationPromptController::class)
                ->name('laboratorie_employee.verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('laboratorie_employee.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('laboratorie_employee.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('laboratorie_employee.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
                ->name('laboratorie_employee.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('laboratorie_employee.logout');
});
