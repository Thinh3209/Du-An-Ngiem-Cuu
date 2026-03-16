<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TelegramService;

class LoginController extends Controller
{
    /**
     * Display the security authentication form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Process administrative authentication request
     */
    public function authenticate(Request $request)
    {
        // Validation of credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // Attempting to establish administrative session
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Broadcast successful login to security channel
            TelegramService::sendMessage("🛡️ <b>SHIELD-AI: ACCESS ALERT</b>\nAdministrative session established for: <b>Leader Thinh</b>");

            return redirect()->intended('/dashboard');
        }

        // Return error on failed authentication
        return back()->withErrors([
            'email' => 'Invalid credentials. Access denied to Command Center.',
        ]);
    }

    /**
     * Terminate the current administrative session
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Purge session data and regenerate CSRF token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}