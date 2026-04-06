<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function index(): View
    {
        $currentUser = auth()->user();

        $pendingUsers = User::query()
            ->with('branch')
            ->where('approval_status', 'pending')
            ->where(function (Builder $query) use ($currentUser): void {
                if ($currentUser->isRole('branch_manager')) {
                    $query->where('role', 'private_vet')
                        ->where('branch_id', $currentUser->branch_id);

                    return;
                }

                if ($currentUser->isRole('wilaya_inspector')) {
                    $query->where('role', 'branch_manager')
                        ->where('wilaya', $currentUser->wilaya);

                    return;
                }

                if ($currentUser->isRole('admin')) {
                    $query->where('role', 'wilaya_inspector');

                    return;
                }

                $query->whereRaw('1 = 0');
            })
            ->latest()
            ->get();

        return view('approvals.index', [
            'pendingUsers' => $pendingUsers,
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        abort_unless($user->approval_status === 'pending', 422);
        abort_unless($currentUser->canApprove($user), 403);

        $user->update([
            'approval_status' => 'approved',
            'approved_by_id' => $currentUser->id,
            'approved_at' => now(),
        ]);

        return back()->with('status', __('messages.approval_done'));
    }

    public function reject(User $user): RedirectResponse
    {
        $currentUser = auth()->user();

        abort_unless($user->approval_status === 'pending', 422);
        abort_unless($currentUser->canApprove($user), 403);

        $user->update([
            'approval_status' => 'rejected',
            'approved_by_id' => $currentUser->id,
            'approved_at' => null,
        ]);

        return back()->with('status', __('messages.rejection_done'));
    }
}