<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, true)) {
            return back()->withErrors([
                'email' => __('messages.invalid_credentials'),
            ])->onlyInput('email');
        }

        $user = $request->user();

        if ($user && ! $user->isApproved()) {
            Auth::logout();

            return back()->withErrors([
                'email' => __('messages.account_pending_approval'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function showRegister(): View
    {
        return view('auth.register', [
            'branches' => Branch::query()->orderBy('wilaya')->orderBy('name')->get(),
        ]);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $branch = Branch::findOrFail((int) $data['branch_id']);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'veterinary_authority_number' => $data['veterinary_authority_number'],
            'wilaya' => $branch->wilaya,
            'branch_id' => $branch->id,
            'preferred_locale' => $data['preferred_locale'],
            'role' => $data['role'],
            'approval_status' => 'pending',
        ]);

        return redirect()->route('login')->with('status', __('messages.account_created_pending'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}