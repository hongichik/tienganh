<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('user.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user === null) {
            $displayName = Str::of($credentials['email'])
                ->before('@')
                ->replace(['.', '_', '-'], ' ')
                ->title()
                ->toString();

            $user = User::create([
                'name' => $displayName !== '' ? $displayName : 'Nguoi dung moi',
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ]);
        } elseif (! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Mật khẩu không đúng.'])
                ->onlyInput('email');
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended(route('user.home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}