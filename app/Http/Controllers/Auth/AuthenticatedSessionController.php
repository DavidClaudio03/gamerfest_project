<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use GuzzleHttp\Client;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

        /**
     * Verifies the Google reCAPTCHA response.
     */
    protected function verifyRecaptcha($token)
    {
        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret' => env('RECAPTCHA_SECRET'),
                    'response' => $token
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());

        return $body->success;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $recaptchaIsValid = $this->verifyRecaptcha($request->input('recaptcha'));

        // if (!$recaptchaIsValid) {
        //     return back()->withErrors(['recaptcha' => 'Invalid reCAPTCHA.']);
        // }

        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } elseif ($user->hasRole('jugador')) {
            return redirect()->intended(RouteServiceProvider::BASE);
        }

        return redirect()->intended(RouteServiceProvider::BASE);
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
