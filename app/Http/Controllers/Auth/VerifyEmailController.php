<?php

namespace App\Http\Controllers\Auth;

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
        $roleSlug = $request->user()->role?->slug;
        $targetRoute = match ($roleSlug) {
            'leader' => route('leader.dashboard', absolute: false),
            'administrator' => route('admin.dashboard', absolute: false),
            default => route('verifier.dashboard', absolute: false),
        };

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($targetRoute.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended($targetRoute.'?verified=1');
    }
}
