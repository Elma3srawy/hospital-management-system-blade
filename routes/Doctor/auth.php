<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\Auth\PasswordController;
use App\Http\Controllers\Doctor\Auth\NewPasswordController;
use App\Http\Controllers\Backend\Auth\VerifyEmailController;
use App\Http\Controllers\Doctor\Auth\RegisteredUserController;
use App\Http\Controllers\Doctor\Auth\PasswordResetLinkController;
use App\Http\Controllers\Doctor\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Backend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Backend\Auth\EmailVerificationNotificationController;


Route::middleware('guest:admin,patient,doctor,ray_employee,laboratorie_employee')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('doctor.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('doctor.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('doctor.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('doctor.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('doctor.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('doctor.password.store');
});

Route::middleware('auth:doctor')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('doctor.verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('doctor.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('doctor.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('doctor.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
                ->name('doctor.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('doctor.logout');
});
