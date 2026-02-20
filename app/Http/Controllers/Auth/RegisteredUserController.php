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
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tipo_documento' => ['required', 'string', 'in:CC,CE,TI,PP,NIT'],
            'numero_documento' => ['required', 'string', 'max:50'],
            'celular' => ['required', 'string', 'max:20'],
            'organizacion' => ['nullable', 'string', 'max:255'],
            'acepta_tratamiento_datos' => ['accepted'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'acepta_tratamiento_datos.accepted' => 'Debe aceptar la Política de Tratamiento de Datos Personales.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'celular' => $request->celular,
            'organizacion' => $request->organizacion,
            'acepta_tratamiento_datos' => true,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
