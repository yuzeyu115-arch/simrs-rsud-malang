<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        // Mock Login for development/demo purposes
        if (env('GOOGLE_CLIENT_ID') === 'YOUR_GOOGLE_CLIENT_ID_HERE' || empty(env('GOOGLE_CLIENT_ID'))) {
            try {
                $user = User::firstOrCreate(
                    ['email' => 'admin@rs-sahabat.com'],
                    [
                        'name' => 'Admin RS SAHABAT',
                        'password' => bcrypt('password'),
                        'role' => 'admin',
                        'google_id' => 'mock_google_id_123'
                    ]
                );
                Auth::login($user);
            } catch (\Exception $e) {
                // If DB is down, just redirect to dashboard (which has its own fallback)
                // or log in with a temporary session if possible.
                // For now, we'll just try to continue to the dashboard.
            }
            // Add a small delay to allow the "Connecting..." screen to be seen
            sleep(1);
            return redirect()->intended('dashboard');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // Update google_id if it was null (found by email)
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ]);
                }
                
                Auth::login($user);
            } else {
                // Create new user
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)), // Dummy password
                    'role' => 'admin', // Default role
                ]);

                Auth::login($newUser);
            }

            return redirect()->intended('dashboard');

        } catch (Exception $e) {
            return redirect('/login')->withErrors(['google_error' => 'Gagal login menggunakan Google: ' . $e->getMessage()]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
