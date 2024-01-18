<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const ADMIN = '/admin/dashboard';
    public const DOCTOR = '/doctor/dashboard';
    public const PATIENT = '/patient/dashboard';
    public const RAY_EMPLOYEE = '/ray_employee/dashboard';
    public const LABORATORIE_EMPLOYEE = '/laboratorie_employee/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });


        $this->routes(function () {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale()."/doctor")
                ->group(base_path('routes/Doctor/doctor.php'));
            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale()."/admin")
                ->group(base_path('routes/Admin/admin.php'));
            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale()."/patient")
                ->group(base_path('routes/Patient/patient.php'));
            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale()."/ray_employee")
                ->group(base_path('routes/RayEmployee/ray_employee.php'));
            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale()."/laboratorie_employee")
                ->group(base_path('routes/LaboratoryEmployee/laboratory_employee.php'));
            Route::middleware('web')
                ->prefix(LaravelLocalization::setLocale())
                ->group(base_path('routes/web.php'));
        });
    }
}
