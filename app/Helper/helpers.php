<?php

use App\Providers\RouteServiceProvider;

if (!function_exists('current_guard')) {
    function current_guard():string|null
    {

        $userType = match (true) {
            auth('admin')->check() => "admin",
            auth('patient')->check() => "patient",
            auth('doctor')->check() => "doctor",
            auth('ray_employee')->check() => "ray_employee",
            auth('laboratorie_employee')->check() => "laboratorie_employee",
            default => null,
        };

        return $userType;

    }
}
if (!function_exists('RedirectIfAuth')) {
    function RedirectIfAuth()
    {

        $redirectRoute = match (current_guard()) {
            'admin' => RouteServiceProvider::ADMIN,
            'doctor' => RouteServiceProvider::DOCTOR,
            'patient' => RouteServiceProvider::PATIENT,
            'ray_employee' => RouteServiceProvider::RAY_EMPLOYEE,
            'laboratorie_employee' => RouteServiceProvider::LABORATORIE_EMPLOYEE,
            default => null,
        };


        return $redirectRoute;

    }
}


?>
