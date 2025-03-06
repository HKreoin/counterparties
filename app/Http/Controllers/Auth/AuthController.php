<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\LoginUserDTO;
use App\DTO\Auth\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function registerForm(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function loginForm(): Response
    {
        return Inertia::render('Auth/Login');
    }

    public function register(RegisterUserDTO $data): RedirectResponse
    {
        //Register
        $user = User::create($data->all());
        //Login
        Auth::login($user);
        //Redirect
        return redirect()->route('counterparties.index')->with('success', 'Вы успешно зарегистрированы!');
    }

    public function login(LoginUserDTO $data, Request $request): RedirectResponse
    {
        if (Auth::attempt((array)$data, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('counterparties.index');
        }

        return back()->withErrors([
            'email' => 'Такой адрес электронной почты не зарегестрирован',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
