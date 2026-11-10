<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Look up even soft-deleted users — needed to detect bans
        $existing = User::withTrashed()
            ->where('username', $credentials['username'])
            ->first();

        if ($existing && $existing->trashed()) {
            // Expired ban → auto-restore and let them in
            if ($existing->banExpired()) {
                $existing->forceFill([
                    'banned_until' => null,
                    'ban_reason'   => null,
                ])->save();
                $existing->restore();
            } else {
                // Active ban → show reason + time remaining
                $reason = $existing->ban_reason
                    ? "Reason: {$existing->ban_reason}."
                    : 'No reason was given.';

                $when = $existing->banned_until
                    ? "Ban expires {$existing->banned_until->toDayDateTimeString()} ({$existing->banned_until->diffForHumans()})."
                    : 'This ban is permanent.';

                return back()
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors([
                        'username' => "You are banned. {$reason} {$when}",
                    ]);
            }
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors([
                    'username' => 'These credentials do not match our records.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'You are logged in!');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nickname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'alpha_dash'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create($validatedData);

        Auth::login($user);

        return redirect()->intended('/')->with('success', 'You are registered and logged in!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You are logged out!');
    }
}
