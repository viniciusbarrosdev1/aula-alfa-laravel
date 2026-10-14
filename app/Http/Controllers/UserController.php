<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);

        return view('user.index', [
            'users' => $users,
            'title' => 'Lista de usuario do Sistema',
        ]);
    }

    public function show(int $id)
    {
        $user = new User;
        $user = $user->show_user($id);

        return view('user.show', [
            'user' => $user]);

    }

    public function register()
    {
        return view('user.create');
    }

    public function create(Request $request)
    {

        $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create($input);

        return redirect()->route('admin.users.index');
    }

    public function forgotPassword()
    {
        return view('user.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $input = $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        session(['password_reset_email' => $input['email']]);
        session()->forget('password_reset_verified');

        return redirect()->route('password.verify');
    }

    public function verifyCodeForm()
    {
        if (! session()->has('password_reset_email')) {
            return redirect()->route('password.forgot');
        }

        return view('user.verify-code');
    }

    public function verifyCode(Request $request)
    {
        if (! session()->has('password_reset_email')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'code' => 'required|string',
        ]);

        // Apenas para teste: qualquer código preenchido é aceito.
        session(['password_reset_verified' => true]);

        return redirect()->route('password.reset');
    }

    public function resetPasswordForm()
    {
        if (! session('password_reset_verified')) {
            return redirect()->route('password.forgot');
        }

        return view('user.reset-password');
    }

    public function changePassword(Request $request)
    {
        if (! session('password_reset_verified')) {
            return redirect()->route('password.forgot');
        }

        $input = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', session('password_reset_email'))->firstOrFail();
        $user->update(['password' => $input['password']]);

        session()->forget(['password_reset_email', 'password_reset_verified']);

        return redirect()->route('login')->with('status', 'Senha redefinida com sucesso! Você já pode fazer login.');
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha inválidos.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.users.index');
    }
}
