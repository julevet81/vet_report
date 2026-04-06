@extends('layouts.app')

@section('content')
@php
    $dash = '-';
    $petSpecies = [
        'dogs' => __('report.options.dogs'),
        'cats' => __('report.options.cats'),
    ];
    $medicineCategories = [
        'vaccines' => __('report.options.vaccines'),
        'antibiotics' => __('report.options.antibiotics'),
        'anti_inflammatory' => __('report.options.anti_inflammatory'),
        'antiparasitic' => __('report.options.antiparasitic'),
        'other' => __('report.options.other'),
    ];
@endphp

<div class="card p-5 mb-5">
    <div class="grid md:grid-cols-3 gap-3 text-sm">
        <div><strong>{{ __('messages.full_name') }}:</strong> {{ $report->user?->name ?? $dash }}</div>
        <div><strong>{{ __('messages.wilaya') }}:</strong> {{ $report->user?->wilaya ?? $dash }}</div>
        <div><strong>{{ __('messages.branch') }}:</strong> {{ $report->branch?->name ?? $dash }}</div>
        <div><strong>{{ __('messages.report_month') }}:</strong> {{ __('messages.month_names')[$report->report_month] ?? $report->report_month }}</div>
        <div><strong>{{ __('messages.report_year') }}:</strong> {{ $report->report_year }}</div>
        <div><strong>{{ __('messages.status') }}:</strong> {{ __('messages.'.$report->status) }}</div>
    </div>
</div>

<div class="card p-5 mb-5">
    <h3 class="section-title">{{ __('messages.ai_summary') }}</h3>
    <div class="whitespace-pre-line leading-8 text-slate-700">{{ $report->ai_summary ?: $dash }}</div>
</div>

<div class="space-y-5">
    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s1') }}</h3>
        @if(!empty($report->notifiable_diseases))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.disease_name') }}</th>
                        <th>{{ __('report.fields.report_date') }}</th>
                        <th>{{ __('report.fields.herd_count') }}</th>
                        <th>{{ __('report.fields.infected_count') }}</th>
                        <th>{{ __('report.fields.diagnosis_source') }}</th>
                        <th>{{ __('report.fields.breeder_name') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->notifiable_diseases as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $row['disease_name'] ?? $dash }}</td>
                                <td>{{ $row['report_date'] ?? $dash }}</td>
                                <td>{{ $row['herd_count'] ?? $dash }}</td>
                                <td>{{ $row['infected_count'] ?? $dash }}</td>
                                <td>{{ $row['diagnosis_source'] ?? $dash }}</td>
                                <td>{{ $row['breeder_name'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s2') }}</h3>
        @if(!empty($report->lab_requests))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.suspected_disease') }}</th>
                        <th>{{ __('report.fields.sample_source') }}</th>
                        <th>{{ __('report.fields.sample_count') }}</th>
                        <th>{{ __('report.fields.sample_date') }}</th>
                        <th>{{ __('report.fields.breeder_name') }}</th>
                        <th>{{ __('report.fields.location') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->lab_requests as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $row['suspected_disease'] ?? $dash }}</td>
                                <td>{{ $row['sample_source'] ?? $dash }}</td>
                                <td>{{ $row['sample_count'] ?? $dash }}</td>
                                <td>{{ $row['sample_date'] ?? $dash }}</td>
                                <td>{{ $row['breeder_name'] ?? $dash }}</td>
                                <td>{{ $row['location'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s31') }}</h3>
        <div class="grid md:grid-cols-4 gap-3 text-sm">
            <div><strong>{{ __('report.fields.canines') }}:</strong> {{ $report->rabies_vaccination['canines'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.felines') }}:</strong> {{ $report->rabies_vaccination['felines'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.cattle') }}:</strong> {{ $report->rabies_vaccination['cattle'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.equines') }}:</strong> {{ $report->rabies_vaccination['equines'] ?? $dash }}</div>
        </div>
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s32') }}</h3>
        <div class="grid md:grid-cols-3 gap-3 text-sm">
            <div><strong>{{ __('report.fields.vaccinated_heads') }}:</strong> {{ $report->sheep_pox_vaccination['vaccinated_heads'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.breeders_count') }}:</strong> {{ $report->sheep_pox_vaccination['breeders_count'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.doses_given') }}:</strong> {{ $report->sheep_pox_vaccination['doses_given'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.doses_used') }}:</strong> {{ $report->sheep_pox_vaccination['doses_used'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.doses_lost') }}:</strong> {{ $report->sheep_pox_vaccination['doses_lost'] ?? $dash }}</div>
        </div>
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s33') }}</h3>
        <div class="grid md:grid-cols-3 gap-3 text-sm">
            <div><strong>{{ __('report.fields.breeders_count') }}:</strong> {{ $report->fmd_vaccination['breeders_count'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.doses_used') }}:</strong> {{ $report->fmd_vaccination['doses_used'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.milking_cows') }}:</strong> {{ $report->fmd_vaccination['milking_cows'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.heifers') }}:</strong> {{ $report->fmd_vaccination['heifers'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.young_females') }}:</strong> {{ $report->fmd_vaccination['young_females'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.bulls') }}:</strong> {{ $report->fmd_vaccination['bulls'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.calves') }}:</strong> {{ $report->fmd_vaccination['calves'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.young_males') }}:</strong> {{ $report->fmd_vaccination['young_males'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.total') }}:</strong> {{ $report->fmd_vaccination['total'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.doses_lost') }}:</strong> {{ $report->fmd_vaccination['doses_lost'] ?? $dash }}</div>
        </div>
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s34') }}</h3>
        <div class="grid md:grid-cols-3 gap-3 text-sm">
            <div><strong>{{ __('report.fields.cattle') }}:</strong> {{ $report->enterotoxemia_vaccination['cattle'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.sheep') }}:</strong> {{ $report->enterotoxemia_vaccination['sheep'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.goats') }}:</strong> {{ $report->enterotoxemia_vaccination['goats'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.camels') }}:</strong> {{ $report->enterotoxemia_vaccination['camels'] ?? $dash }}</div>
            <div><strong>{{ __('report.fields.rabbits') }}:</strong> {{ $report->enterotoxemia_vaccination['rabbits'] ?? $dash }}</div>
        </div>
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s4') }}</h3>
        @if(!empty($report->pet_vaccinations))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.species') }}</th>
                        <th>{{ __('report.fields.animal_count') }}</th>
                        <th>{{ __('report.fields.vaccine_type') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->pet_vaccinations as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $petSpecies[$row['species'] ?? ''] ?? ($row['species'] ?? $dash) }}</td>
                                <td>{{ $row['count'] ?? $dash }}</td>
                                <td>{{ $row['vaccine_type'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s5') }}</h3>
        @if(!empty($report->parasite_treatments))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.species') }}</th>
                        <th>{{ __('report.fields.count') }}</th>
                        <th>{{ __('report.fields.drug_used') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->parasite_treatments as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $row['species'] ?? $dash }}</td>
                                <td>{{ $row['count'] ?? $dash }}</td>
                                <td>{{ $row['drug'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s6') }}</h3>
        @if(!empty($report->artificial_inseminations))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.beneficiary_name') }}</th>
                        <th>{{ __('report.fields.address') }}</th>
                        <th>{{ __('report.fields.animal_count') }}</th>
                        <th>{{ __('report.fields.species') }}</th>
                        <th>{{ __('report.fields.insemination_date') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->artificial_inseminations as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $row['beneficiary_name'] ?? $dash }}</td>
                                <td>{{ $row['address'] ?? $dash }}</td>
                                <td>{{ $row['vaccinated_count'] ?? $dash }}</td>
                                <td>{{ $row['species'] ?? $dash }}</td>
                                <td>{{ $row['insemination_date'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s7') }}</h3>
        @if(!empty($report->poultry_followups))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.breeder_name') }}</th>
                        <th>{{ __('report.fields.address') }}</th>
                        <th>{{ __('report.fields.bird_type') }}</th>
                        <th>{{ __('report.fields.visit_date') }}</th>
                        <th>{{ __('report.fields.diseases') }}</th>
                        <th>{{ __('report.fields.treatment') }}</th>
                        <th>{{ __('report.fields.vaccines') }}</th>
                        <th>{{ __('report.fields.notes') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->poultry_followups as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $row['breeder_name'] ?? $dash }}</td>
                                <td>{{ $row['address'] ?? $dash }}</td>
                                <td>{{ $row['bird_type'] ?? $dash }}</td>
                                <td>{{ $row['visit_date'] ?? $dash }}</td>
                                <td>{{ $row['detected_diseases'] ?? $dash }}</td>
                                <td>{{ $row['treatment_used'] ?? $dash }}</td>
                                <td>{{ $row['applied_vaccines'] ?? $dash }}</td>
                                <td>{{ $row['notes'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s8') }}</h3>
        @if(!empty($report->beekeeping_followups))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.breeder_name') }}</th>
                        <th>{{ __('report.fields.address') }}</th>
                        <th>{{ __('report.fields.diseases') }}</th>
                        <th>{{ __('report.fields.treatment') }}</th>
                        <th>{{ __('report.fields.hive_count') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->beekeeping_followups as $row)
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $row['breeder_name'] ?? $dash }}</td>
                                <td>{{ $row['address'] ?? $dash }}</td>
                                <td>{{ $row['diseases'] ?? $dash }}</td>
                                <td>{{ $row['applied_treatment'] ?? $dash }}</td>
                                <td>{{ $row['hive_count'] ?? $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s9') }}</h3>
        @if(!empty($report->other_infectious_diseases))
            @php
                $otherSpecies = [
                    'cattle' => __('report.fields.cattle'),
                    'sheep' => __('report.fields.sheep'),
                    'goats' => __('report.fields.goats'),
                    'camels' => __('report.fields.camels'),
                    'rabbits' => __('report.fields.rabbits'),
                    'birds' => __('report.fields.bird_type'),
                    'bees' => __('report.sections.s8'),
                ];
            @endphp
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.species') }}</th>
                        <th>{{ __('report.fields.disease_name') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->other_infectious_diseases as $row)
                            @php
                                $knownDiseases = collect($row['diseases'] ?? [])->filter();
                                $customDiseases = collect(explode(',', (string) ($row['custom_diseases'] ?? '')))->map(fn ($item) => trim($item))->filter();
                                $legacyDiseases = collect(isset($row['disease']) ? [$row['disease']] : [])->filter();
                                $allDiseases = $knownDiseases->merge($customDiseases)->merge($legacyDiseases)->unique()->values();
                            @endphp
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $otherSpecies[$row['species'] ?? ''] ?? ($row['species'] ?? $dash) }}</td>
                                <td>{{ $allDiseases->isNotEmpty() ? $allDiseases->join(', ') : $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>
    <div class="card p-5">
        <h3 class="section-title">{{ __('report.sections.s10') }}</h3>
        @if(!empty($report->medicines_and_vaccines))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left text-slate-500">
                        <th class="py-2">{{ __('report.fields.category') }}</th>
                        <th>{{ __('report.fields.medicines') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach($report->medicines_and_vaccines as $row)
                            @php
                                $knownMedicines = collect($row['medicines'] ?? [])->filter();
                                $customMedicines = collect(explode(',', (string) ($row['custom_medicines'] ?? '')))->map(fn ($item) => trim($item))->filter();
                                $legacyMedicines = collect(isset($row['item_name']) ? [$row['item_name']] : [])->filter();
                                $allMedicines = $knownMedicines->merge($customMedicines)->merge($legacyMedicines)->unique()->values();
                            @endphp
                            <tr class="border-t border-slate-100">
                                <td class="py-2">{{ $medicineCategories[$row['category'] ?? ''] ?? ($row['category'] ?? $dash) }}</td>
                                <td>{{ $allMedicines->isNotEmpty() ? $allMedicines->join(', ') : $dash }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>{{ $dash }}</p>
        @endif
    </div>

    <div class="card p-5">
        <h3 class="section-title">{{ __('messages.suggestions') }}</h3>
        <p>{{ $report->suggestions ?: $dash }}</p>
    </div>
</div>
@endsection


