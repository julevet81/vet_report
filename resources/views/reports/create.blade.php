@extends('layouts.app')

@section('content')
@php
    $speciesOptions = [
        'cattle' => __('report.fields.cattle'),
        'sheep' => __('report.fields.sheep'),
        'goats' => __('report.fields.goats'),
        'camels' => __('report.fields.camels'),
        'rabbits' => __('report.fields.rabbits'),
        'birds' => __('report.fields.bird_type'),
        'bees' => __('report.sections.s8'),
    ];

    $diseaseCatalog = app()->getLocale() === 'fr'
        ? [
            'cattle' => ['Brucellose', 'Tuberculose bovine', 'Dermatose nodulaire'],
            'sheep' => ['Enterotoxemie', 'PPR', 'Clavellee'],
            'goats' => ['PPR', 'Agalactie contagieuse', 'Brucellose caprine'],
            'camels' => ['Trypanosomose', 'Gale sarcoptique', 'Pasteurellose'],
            'rabbits' => ['Myxomatose', 'VHD', 'Coccidiose'],
            'birds' => ['Influenza aviaire', 'Newcastle', 'Salmonellose'],
            'bees' => ['Varroose', 'Loque americaine', 'Nosemose'],
        ]
        : [
            'cattle' => ['FMD', 'Bovine tuberculosis', 'Lumpy skin disease'],
            'sheep' => ['Enterotoxemia', 'PPR', 'Sheep pox'],
            'goats' => ['PPR', 'Caprine brucellosis', 'Contagious caprine pleuropneumonia'],
            'camels' => ['Trypanosomiasis', 'Sarcoptic mange', 'Pasteurellosis'],
            'rabbits' => ['Myxomatosis', 'VHD', 'Coccidiosis'],
            'birds' => ['Avian influenza', 'Newcastle disease', 'Salmonellosis'],
            'bees' => ['Varroosis', 'American foulbrood', 'Nosemosis'],
        ];

    $medicineCatalog = app()->getLocale() === 'fr'
        ? [
            'vaccines' => ['Rabique', 'PPR', 'Fievre aphteuse'],
            'antibiotics' => ['Oxytetracycline', 'Penicilline', 'Enrofloxacine'],
            'anti_inflammatory' => ['Flunixine', 'Meloxicam', 'Ketoprofene'],
            'antiparasitic' => ['Ivermectine', 'Albendazole', 'Deltamethrine'],
            'other' => ['Vitamines', 'Electrolytes', 'Probiotiques'],
        ]
        : [
            'vaccines' => ['Rabies vaccine', 'PPR vaccine', 'FMD vaccine'],
            'antibiotics' => ['Oxytetracycline', 'Penicillin', 'Enrofloxacin'],
            'anti_inflammatory' => ['Flunixin', 'Meloxicam', 'Ketoprofen'],
            'antiparasitic' => ['Ivermectin', 'Albendazole', 'Deltamethrin'],
            'other' => ['Vitamins', 'Electrolytes', 'Probiotics'],
        ];
@endphp
<form action="{{ route('reports.store') }}" method="POST" class="space-y-5">
    @csrf

    <div class="card p-5 grid md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1">{{ __('messages.report_year') }}</label>
            <input class="input" type="number" name="report_year" value="{{ old('report_year', now()->year) }}" required>
        </div>
        <div>
            <label class="block mb-1">{{ __('messages.report_month') }}</label>
            <input class="input" type="number" name="report_month" min="1" max="12" value="{{ old('report_month', now()->month) }}" required>
        </div>
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s1') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item>
                <input class="input" name="notifiable_diseases[__INDEX__][disease_name]" placeholder="{{ __('report.fields.disease_name') }}">
                <input class="input" type="date" name="notifiable_diseases[__INDEX__][report_date]">
                <input class="input" type="number" min="0" name="notifiable_diseases[__INDEX__][herd_count]" placeholder="{{ __('report.fields.herd_count') }}">
                <input class="input" type="number" min="0" name="notifiable_diseases[__INDEX__][infected_count]" placeholder="{{ __('report.fields.infected_count') }}">
                <input class="input" name="notifiable_diseases[__INDEX__][diagnosis_source]" placeholder="{{ __('report.fields.diagnosis_source') }}">
                <input class="input" name="notifiable_diseases[__INDEX__][breeder_name]" placeholder="{{ __('report.fields.breeder_name') }}">
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s2') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item>
                <input class="input" name="lab_requests[__INDEX__][suspected_disease]" placeholder="{{ __('report.fields.suspected_disease') }}">
                <input class="input" name="lab_requests[__INDEX__][sample_source]" placeholder="{{ __('report.fields.sample_source') }}">
                <input class="input" type="number" min="0" name="lab_requests[__INDEX__][sample_count]" placeholder="{{ __('report.fields.sample_count') }}">
                <input class="input" type="date" name="lab_requests[__INDEX__][sample_date]">
                <input class="input" name="lab_requests[__INDEX__][breeder_name]" placeholder="{{ __('report.fields.breeder_name') }}">
                <input class="input" name="lab_requests[__INDEX__][location]" placeholder="{{ __('report.fields.location') }}">
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5 grid md:grid-cols-2 gap-4">
        <h3 class="section-title md:col-span-2">{{ __('report.sections.s31') }}</h3>
        <input class="input" type="number" min="0" name="rabies_vaccination[canines]" placeholder="{{ __('report.fields.canines') }}">
        <input class="input" type="number" min="0" name="rabies_vaccination[felines]" placeholder="{{ __('report.fields.felines') }}">
        <input class="input" type="number" min="0" name="rabies_vaccination[cattle]" placeholder="{{ __('report.fields.cattle') }}">
        <input class="input" type="number" min="0" name="rabies_vaccination[equines]" placeholder="{{ __('report.fields.equines') }}">
    </div>

    <div class="card p-5 grid md:grid-cols-2 gap-4">
        <h3 class="section-title md:col-span-2">{{ __('report.sections.s32') }}</h3>
        <input class="input" type="number" min="0" name="sheep_pox_vaccination[vaccinated_heads]" placeholder="{{ __('report.fields.vaccinated_heads') }}">
        <input class="input" type="number" min="0" name="sheep_pox_vaccination[breeders_count]" placeholder="{{ __('report.fields.breeders_count') }}">
        <input class="input" type="number" min="0" name="sheep_pox_vaccination[doses_given]" placeholder="{{ __('report.fields.doses_given') }}">
        <input class="input" type="number" min="0" name="sheep_pox_vaccination[doses_used]" placeholder="{{ __('report.fields.doses_used') }}">
        <input class="input" type="number" min="0" name="sheep_pox_vaccination[doses_lost]" placeholder="{{ __('report.fields.doses_lost') }}">
    </div>

    <div class="card p-5 grid md:grid-cols-2 gap-4">
        <h3 class="section-title md:col-span-2">{{ __('report.sections.s33') }}</h3>
        <input class="input" type="number" min="0" name="fmd_vaccination[breeders_count]" placeholder="{{ __('report.fields.breeders_count') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[doses_used]" placeholder="{{ __('report.fields.doses_used') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[milking_cows]" placeholder="{{ __('report.fields.milking_cows') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[heifers]" placeholder="{{ __('report.fields.heifers') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[young_females]" placeholder="{{ __('report.fields.young_females') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[bulls]" placeholder="{{ __('report.fields.bulls') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[calves]" placeholder="{{ __('report.fields.calves') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[young_males]" placeholder="{{ __('report.fields.young_males') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[total]" placeholder="{{ __('report.fields.total') }}">
        <input class="input" type="number" min="0" name="fmd_vaccination[doses_lost]" placeholder="{{ __('report.fields.doses_lost') }}">
    </div>

    <div class="card p-5 grid md:grid-cols-2 gap-4">
        <h3 class="section-title md:col-span-2">{{ __('report.sections.s34') }}</h3>
        <input class="input" type="number" min="0" name="enterotoxemia_vaccination[cattle]" placeholder="{{ __('report.fields.cattle') }}">
        <input class="input" type="number" min="0" name="enterotoxemia_vaccination[sheep]" placeholder="{{ __('report.fields.sheep') }}">
        <input class="input" type="number" min="0" name="enterotoxemia_vaccination[goats]" placeholder="{{ __('report.fields.goats') }}">
        <input class="input" type="number" min="0" name="enterotoxemia_vaccination[camels]" placeholder="{{ __('report.fields.camels') }}">
        <input class="input" type="number" min="0" name="enterotoxemia_vaccination[rabbits]" placeholder="{{ __('report.fields.rabbits') }}">
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s4') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item>
                <select class="input" name="pet_vaccinations[__INDEX__][species]">
                    <option value="dogs">{{ __('report.options.dogs') }}</option>
                    <option value="cats">{{ __('report.options.cats') }}</option>
                </select>
                <input class="input" type="number" min="0" name="pet_vaccinations[__INDEX__][count]" placeholder="{{ __('report.fields.animal_count') }}">
                <input class="input" name="pet_vaccinations[__INDEX__][vaccine_type]" placeholder="{{ __('report.fields.vaccine_type') }}">
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s5') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item>
                <input class="input" name="parasite_treatments[__INDEX__][species]" placeholder="{{ __('report.fields.species') }}">
                <input class="input" type="number" min="0" name="parasite_treatments[__INDEX__][count]" placeholder="{{ __('report.fields.count') }}">
                <input class="input" name="parasite_treatments[__INDEX__][drug]" placeholder="{{ __('report.fields.drug_used') }}">
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s6') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item>
                <input class="input" name="artificial_inseminations[__INDEX__][beneficiary_name]" placeholder="{{ __('report.fields.beneficiary_name') }}">
                <input class="input" name="artificial_inseminations[__INDEX__][address]" placeholder="{{ __('report.fields.address') }}">
                <input class="input" type="number" min="0" name="artificial_inseminations[__INDEX__][vaccinated_count]" placeholder="{{ __('report.fields.animal_count') }}">
                <input class="input" name="artificial_inseminations[__INDEX__][species]" placeholder="{{ __('report.fields.species') }}">
                <input class="input" type="date" name="artificial_inseminations[__INDEX__][insemination_date]">
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s7') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-2 gap-3" data-item>
                <input class="input" name="poultry_followups[__INDEX__][breeder_name]" placeholder="{{ __('report.fields.breeder_name') }}">
                <input class="input" name="poultry_followups[__INDEX__][address]" placeholder="{{ __('report.fields.address') }}">
                <input class="input" name="poultry_followups[__INDEX__][bird_type]" placeholder="{{ __('report.fields.bird_type') }}">
                <input class="input" type="date" name="poultry_followups[__INDEX__][visit_date]">
                <input class="input" name="poultry_followups[__INDEX__][detected_diseases]" placeholder="{{ __('report.fields.diseases') }}">
                <input class="input" name="poultry_followups[__INDEX__][treatment_used]" placeholder="{{ __('report.fields.treatment') }}">
                <input class="input" name="poultry_followups[__INDEX__][applied_vaccines]" placeholder="{{ __('report.fields.vaccines') }}">
                <input class="input" name="poultry_followups[__INDEX__][notes]" placeholder="{{ __('report.fields.notes') }}">
                <button type="button" class="btn btn-secondary md:col-span-2" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s8') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-2 gap-3" data-item>
                <input class="input" name="beekeeping_followups[__INDEX__][breeder_name]" placeholder="{{ __('report.fields.breeder_name') }}">
                <input class="input" name="beekeeping_followups[__INDEX__][address]" placeholder="{{ __('report.fields.address') }}">
                <input class="input" name="beekeeping_followups[__INDEX__][diseases]" placeholder="{{ __('report.fields.diseases') }}">
                <input class="input" name="beekeeping_followups[__INDEX__][applied_treatment]" placeholder="{{ __('report.fields.treatment') }}">
                <input class="input" type="number" min="0" name="beekeeping_followups[__INDEX__][hive_count]" placeholder="{{ __('report.fields.hive_count') }}">
                <button type="button" class="btn btn-secondary md:col-span-2" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater data-disease-catalog='@json($diseaseCatalog)'>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s9') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item data-disease-row>
                <select class="input" name="other_infectious_diseases[__INDEX__][species]" data-disease-species>
                    @foreach($speciesOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                <div class="md:col-span-2 border rounded-lg p-3 bg-slate-50">
                    <p class="text-sm font-semibold mb-2">{{ __('report.available_diseases') }}</p>
                    <div class="grid sm:grid-cols-2 gap-2" data-disease-options data-name-prefix="other_infectious_diseases[__INDEX__][diseases][]"></div>
                </div>
                <div class="md:col-span-2 flex flex-col sm:flex-row gap-2">
                    <input class="input flex-1" name="other_infectious_diseases[__INDEX__][custom_diseases]" data-custom-disease-input placeholder="{{ __('report.custom_diseases_placeholder') }}">
                    <button type="button" class="btn btn-secondary whitespace-nowrap" data-add-disease>{{ __('report.add_disease_to_list') }}</button>
                </div>
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5" data-repeater data-medicine-catalog='@json($medicineCatalog)'>
        <div class="flex justify-between items-center mb-3">
            <h3 class="section-title">{{ __('report.sections.s10') }}</h3>
            <button type="button" class="btn btn-secondary" data-add-item>{{ __('report.add_row') }}</button>
        </div>
        <div class="space-y-3" data-list></div>
        <template>
            <div class="border rounded-xl p-3 grid md:grid-cols-3 gap-3" data-item data-medicine-row>
                <select class="input" name="medicines_and_vaccines[__INDEX__][category]" data-medicine-category>
                    <option value="vaccines">{{ __('report.options.vaccines') }}</option>
                    <option value="antibiotics">{{ __('report.options.antibiotics') }}</option>
                    <option value="anti_inflammatory">{{ __('report.options.anti_inflammatory') }}</option>
                    <option value="antiparasitic">{{ __('report.options.antiparasitic') }}</option>
                    <option value="other">{{ __('report.options.other') }}</option>
                </select>
                <div class="md:col-span-2 border rounded-lg p-3 bg-slate-50">
                    <p class="text-sm font-semibold mb-2">{{ __('report.available_medicines') }}</p>
                    <div class="grid sm:grid-cols-2 gap-2" data-medicine-options data-name-prefix="medicines_and_vaccines[__INDEX__][medicines][]"></div>
                </div>
                <div class="md:col-span-2 flex flex-col sm:flex-row gap-2">
                    <input class="input flex-1" name="medicines_and_vaccines[__INDEX__][custom_medicines]" data-custom-medicine-input placeholder="{{ __('report.custom_medicines_placeholder') }}">
                    <button type="button" class="btn btn-secondary whitespace-nowrap" data-add-medicine>{{ __('report.add_medicine_to_list') }}</button>
                </div>
                <button type="button" class="btn btn-secondary md:col-span-3" data-remove-item>{{ __('report.delete') }}</button>
            </div>
        </template>
    </div>

    <div class="card p-5">
        <h3 class="section-title">11- {{ __('messages.suggestions') }}</h3>
        <textarea class="input min-h-28" name="suggestions" placeholder="{{ __('report.suggestions_placeholder') }}">{{ old('suggestions') }}</textarea>
    </div>

    <button class="btn btn-primary w-full" type="submit">{{ __('messages.save_report') }}</button>
</form>
@endsection

