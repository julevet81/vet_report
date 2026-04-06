<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->with('branch')->latest()->paginate(20),
            'branches' => Branch::query()->orderBy('wilaya')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['admin', 'wilaya_inspector', 'branch_manager', 'private_vet'])],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'preferred_locale' => ['required', Rule::in(['ar', 'fr'])],
        ]);

        $branch = isset($data['branch_id']) ? Branch::find($data['branch_id']) : null;

        $user->update([
            'role' => $data['role'],
            'branch_id' => $branch?->id,
            'wilaya' => $branch?->wilaya ?? $user->wilaya,
            'preferred_locale' => $data['preferred_locale'],
        ]);

        return back()->with('status', 'User updated successfully.');
    }
}
