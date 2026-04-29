<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'  => 'required|email',
            'locale' => 'sometimes|string|in:en,fr',
        ]);

        // Apply the user's chosen locale so the reset e-mail is sent in
        // their language (resolved by ResetPassword::toMailUsing in
        // AppServiceProvider via __() calls).
        if ($request->filled('locale')) {
            App::setLocale($request->input('locale'));
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_THROTTLED) {
                throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            Log::error('Password reset email failed (transport): '.$e->getMessage());

            throw ValidationException::withMessages([
                'email' => [__('passwords.failed')],
            ]);
        }

        return redirect()->route('password.request')
            ->with('status', __('A reset link will be sent if the account exists.'));
    }
}
