<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonthlyReportRequest;
use App\Models\MonthlyReport;
use App\Services\ReportInsightService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MonthlyReportController extends Controller
{
    public function index(): View
    {
        $reports = $this->scopedReportsQuery()
            ->with(['user', 'branch'])
            ->latest()
            ->paginate(12);

        return view('reports.index', [
            'reports' => $reports,
        ]);
    }

    public function create(): View
    {
        abort_unless(auth()->user()->isRole('private_vet'), 403);

        return view('reports.create');
    }

    public function store(StoreMonthlyReportRequest $request, ReportInsightService $insightService): RedirectResponse
    {
        abort_unless(auth()->user()->isRole('private_vet'), 403);

        $data = $request->validated();

        $report = MonthlyReport::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'report_year' => $data['report_year'],
                'report_month' => $data['report_month'],
            ],
            [
                'branch_id' => auth()->user()->branch_id,
                'status' => 'submitted',
                'notifiable_diseases' => $data['notifiable_diseases'] ?? [],
                'lab_requests' => $data['lab_requests'] ?? [],
                'rabies_vaccination' => $data['rabies_vaccination'] ?? [],
                'sheep_pox_vaccination' => $data['sheep_pox_vaccination'] ?? [],
                'fmd_vaccination' => $data['fmd_vaccination'] ?? [],
                'enterotoxemia_vaccination' => $data['enterotoxemia_vaccination'] ?? [],
                'pet_vaccinations' => $data['pet_vaccinations'] ?? [],
                'parasite_treatments' => $data['parasite_treatments'] ?? [],
                'artificial_inseminations' => $data['artificial_inseminations'] ?? [],
                'poultry_followups' => $data['poultry_followups'] ?? [],
                'beekeeping_followups' => $data['beekeeping_followups'] ?? [],
                'other_infectious_diseases' => $data['other_infectious_diseases'] ?? [],
                'medicines_and_vaccines' => $data['medicines_and_vaccines'] ?? [],
                'suggestions' => $data['suggestions'] ?? null,
            ]
        );

        $report->update([
            'ai_summary' => $insightService->generateSummary($report),
        ]);

        return redirect()->route('reports.show', $report)->with('status', __('messages.report_saved'));
    }

    public function show(MonthlyReport $report): View
    {
        abort_unless($this->canView($report), 403);

        return view('reports.show', [
            'report' => $report->load(['user', 'branch']),
        ]);
    }

    private function scopedReportsQuery(): Builder
    {
        $user = auth()->user();
        $query = MonthlyReport::query();

        if ($user->isRole('private_vet')) {
            $query->where('user_id', $user->id);
        } elseif ($user->isRole('branch_manager')) {
            $query->where('branch_id', $user->branch_id);
        } elseif ($user->isRole('wilaya_inspector')) {
            $query->whereHas('user', fn (Builder $builder) => $builder->where('wilaya', $user->wilaya));
        }

        return $query;
    }

    private function canView(MonthlyReport $report): bool
    {
        $user = auth()->user();

        if ($user->isRole('admin')) {
            return true;
        }

        if ($user->isRole('private_vet')) {
            return $report->user_id === $user->id;
        }

        if ($user->isRole('branch_manager')) {
            return (int) $report->branch_id === (int) $user->branch_id;
        }

        if ($user->isRole('wilaya_inspector')) {
            return $report->user?->wilaya === $user->wilaya;
        }

        return false;
    }
}
