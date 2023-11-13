<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $email    = $request->email;
        $userId   = User::where('email', $email)->value('id');
        $roleId   = DB::table('role_user')->where('user_id', $userId)->value('role_id');
        $roleName = DB::table('roles')->where('id', $roleId)->value('name');
        
        if ($roleName == 'user') {

            $request->authenticate();
            $request->session()->regenerate();

            return redirect()->route('user.profile');
        }

        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
