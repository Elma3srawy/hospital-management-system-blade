<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\Auth\PasswordController;
use App\Http\Controllers\Backend\Auth\VerifyEmailController;
use App\Http\Controllers\Patient\Auth\NewPasswordController;
use App\Http\Controllers\Patient\Auth\RegisteredUserController;
use App\Http\Controllers\Patient\Auth\PasswordResetLinkController;
use App\Http\Controllers\Patient\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Backend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Backend\Auth\EmailVerificationNotificationController;


Route::middleware('guest:admin,patient,doctor,ray_employee,laboratorie_employee')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('patient.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('patient.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('patient.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('patient.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('patient.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('patient.password.store');
});

Route::middleware('auth:patient')->group(function () {
    Route::get('patient.verify-email', EmailVerificationPromptController::class)
                ->name('patient.verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('patient.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('patient.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('patient.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
                ->name('patient.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('patient.logout');
});
