<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user(current_guard())->hasVerifiedEmail()
                        ? redirect()->intended(RedirectIFAuth())
                        : match(current_guard()) {
                            'admin' => view('auth.admin.verify-email'),
                            'doctor' => view('auth.doctor.verify-email'),
                            'patient' => view('auth.patient.verify-email'),
                            'ray_employee' => view('auth.ray_employee.verify-email'),
                            'laboratorie_employee' => view('auth.laboratorie_employee.verify-email'),
                            default => abort(404),
                        };
    
    }
}
