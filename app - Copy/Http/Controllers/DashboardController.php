<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        $reportsQuery = MonthlyReport::query()->with(['user', 'branch']);

        if ($user->isRole('private_vet')) {
            $reportsQuery->where('user_id', $user->id);
        } elseif ($user->isRole('branch_manager')) {
            $reportsQuery->where('branch_id', $user->branch_id);
        } elseif ($user->isRole('wilaya_inspector')) {
            $reportsQuery->whereHas('user', fn (Builder $query) => $query->where('wilaya', $user->wilaya));
        }

        return view('dashboard', [
            'reportsCount' => (clone $reportsQuery)->count(),
            'draftReports' => (clone $reportsQuery)->where('status', 'draft')->count(),
            'reviewedReports' => (clone $reportsQuery)->where('status', 'reviewed')->count(),
            'latestReports' => (clone $reportsQuery)->latest()->limit(8)->get(),
        ]);
    }
}
