<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
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
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $partOneCod = strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));
        $partTwoCod = strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));
        $userCod = $partOneCod . '-' . $partTwoCod;

        if (User::where('cod', $userCod)->exists()) {
            // If the code already exists, generate a new one
            $partOneCod = strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));
            $partTwoCod = strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));
            $userCod = $partOneCod . '-' . $partTwoCod;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cod' => $userCod,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('collection');
    }
}
