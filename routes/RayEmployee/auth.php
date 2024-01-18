<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RayEmployee\Auth\PasswordController;
use App\Http\Controllers\Backend\Auth\VerifyEmailController;
use App\Http\Controllers\RayEmployee\Auth\NewPasswordController;
use App\Http\Controllers\RayEmployee\Auth\RegisteredUserController;
use App\Http\Controllers\RayEmployee\Auth\PasswordResetLinkController;
use App\Http\Controllers\RayEmployee\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Backend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Backend\Auth\EmailVerificationNotificationController;


Route::middleware('guest:admin,patient,doctor,ray_employee,laboratorie_employee')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('ray_employee.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('ray_employee.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('ray_employee.password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('ray_employee.password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('ray_employee.password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('ray_employee.password.store');
});

Route::middleware('auth:ray_employee')->group(function () {
    Route::get('ray_employee.verify-email', EmailVerificationPromptController::class)
                ->name('ray_employee.verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('ray_employee.verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('ray_employee.verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('ray_employee.password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
                ->name('ray_employee.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('ray_employee.logout');
});
