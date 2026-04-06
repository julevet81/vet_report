@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-3 gap-4 mb-5">
    <div class="kpi">
        <p class="text-sm text-slate-500">{{ __('messages.reports') }}</p>
        <p class="text-3xl font-extrabold">{{ $reportsCount }}</p>
    </div>
    <div class="kpi">
        <p class="text-sm text-slate-500">{{ __('messages.draft') }}</p>
        <p class="text-3xl font-extrabold">{{ $draftReports }}</p>
    </div>
    <div class="kpi">
        <p class="text-sm text-slate-500">{{ __('messages.reviewed') }}</p>
        <p class="text-3xl font-extrabold">{{ $reviewedReports }}</p>
    </div>
</div>

<div class="card p-5">
    <h3 class="section-title">{{ __('messages.my_scope') }}</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-slate-500 text-left">
                    <th class="py-2">{{ __('messages.full_name') }}</th>
                    <th>{{ __('messages.branch') }}</th>
                    <th>{{ __('messages.report_month') }}</th>
                    <th>{{ __('messages.report_year') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestReports as $report)
                    <tr class="border-t border-slate-100">
                        <td class="py-2">{{ $report->user?->name }}</td>
                        <td>{{ $report->branch?->name }}</td>
                        <td>{{ __('messages.month_names')[$report->report_month] ?? $report->report_month }}</td>
                        <td>{{ $report->report_year }}</td>
                        <td>{{ __('messages.'.$report->status) }}</td>
                        <td><a class="text-emerald-700 font-bold" href="{{ route('reports.show', $report) }}">{{ __('messages.view') }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-4 text-slate-500">-</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
