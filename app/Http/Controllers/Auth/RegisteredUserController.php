<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use GuzzleHttp\Client;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
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
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'phone' => 'required|string|max:10|min:10|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'recaptcha' => 'required',
        ]);

        $recaptchaIsValid = $this->verifyRecaptcha($request->input('recaptcha'));

        if (!$recaptchaIsValid) {
            return back()->withErrors(['recaptcha' => 'Invalid reCAPTCHA.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $defaultRole = Role::where('name', 'jugador')->first();

        if($defaultRole){
            $user->roles()->attach($defaultRole->id);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
}

}
