<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user(current_guard())->hasVerifiedEmail()) {
            return redirect()->intended(RedirectIfAuth().'?verified=1');
        }

        if ($request->user(current_guard())->markEmailAsVerified()) {
            event(new Verified($request->user(current_guard())));
        }

        return redirect()->intended(RedirectIfAuth().'?verified=1');
    }
}
