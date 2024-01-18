<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user(current_guard())->hasVerifiedEmail()) {
            return redirect()->intended(RedirectIfAuth());
        }

        $request->user(current_guard())->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
