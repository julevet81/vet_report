<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMonthlyReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'report_year' => ['required', 'integer', 'between:2020,2100'],
            'report_month' => ['required', 'integer', 'between:1,12'],
            'suggestions' => ['nullable', 'string', 'max:5000'],

            'notifiable_diseases' => ['nullable', 'array'],
            'notifiable_diseases.*.disease_name' => ['required_with:notifiable_diseases.*', 'string', 'max:255'],
            'notifiable_diseases.*.report_date' => ['nullable', 'date'],
            'notifiable_diseases.*.herd_count' => ['nullable', 'integer', 'min:0'],
            'notifiable_diseases.*.infected_count' => ['nullable', 'integer', 'min:0'],
            'notifiable_diseases.*.diagnosis_source' => ['nullable', 'string', 'max:255'],
            'notifiable_diseases.*.breeder_name' => ['nullable', 'string', 'max:255'],

            'lab_requests' => ['nullable', 'array'],
            'lab_requests.*.suspected_disease' => ['required_with:lab_requests.*', 'string', 'max:255'],
            'lab_requests.*.sample_source' => ['nullable', 'string', 'max:255'],
            'lab_requests.*.sample_count' => ['nullable', 'integer', 'min:0'],
            'lab_requests.*.sample_date' => ['nullable', 'date'],
            'lab_requests.*.breeder_name' => ['nullable', 'string', 'max:255'],
            'lab_requests.*.location' => ['nullable', 'string', 'max:255'],

            'rabies_vaccination' => ['nullable', 'array'],
            'rabies_vaccination.canines' => ['nullable', 'integer', 'min:0'],
            'rabies_vaccination.felines' => ['nullable', 'integer', 'min:0'],
            'rabies_vaccination.cattle' => ['nullable', 'integer', 'min:0'],
            'rabies_vaccination.equines' => ['nullable', 'integer', 'min:0'],

            'sheep_pox_vaccination' => ['nullable', 'array'],
            'sheep_pox_vaccination.vaccinated_heads' => ['nullable', 'integer', 'min:0'],
            'sheep_pox_vaccination.breeders_count' => ['nullable', 'integer', 'min:0'],
            'sheep_pox_vaccination.doses_given' => ['nullable', 'integer', 'min:0'],
            'sheep_pox_vaccination.doses_used' => ['nullable', 'integer', 'min:0'],
            'sheep_pox_vaccination.doses_lost' => ['nullable', 'integer', 'min:0'],

            'fmd_vaccination' => ['nullable', 'array'],
            'fmd_vaccination.breeders_count' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.doses_used' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.milking_cows' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.heifers' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.young_females' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.bulls' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.calves' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.young_males' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.total' => ['nullable', 'integer', 'min:0'],
            'fmd_vaccination.doses_lost' => ['nullable', 'integer', 'min:0'],

            'enterotoxemia_vaccination' => ['nullable', 'array'],
            'enterotoxemia_vaccination.cattle' => ['nullable', 'integer', 'min:0'],
            'enterotoxemia_vaccination.sheep' => ['nullable', 'integer', 'min:0'],
            'enterotoxemia_vaccination.goats' => ['nullable', 'integer', 'min:0'],
            'enterotoxemia_vaccination.camels' => ['nullable', 'integer', 'min:0'],
            'enterotoxemia_vaccination.rabbits' => ['nullable', 'integer', 'min:0'],

            'pet_vaccinations' => ['nullable', 'array'],
            'pet_vaccinations.*.species' => ['required_with:pet_vaccinations.*', Rule::in(['dogs', 'cats'])],
            'pet_vaccinations.*.count' => ['nullable', 'integer', 'min:0'],
            'pet_vaccinations.*.vaccine_type' => ['nullable', 'string', 'max:255'],

            'parasite_treatments' => ['nullable', 'array'],
            'parasite_treatments.*.species' => ['required_with:parasite_treatments.*', 'string', 'max:100'],
            'parasite_treatments.*.count' => ['nullable', 'integer', 'min:0'],
            'parasite_treatments.*.drug' => ['nullable', 'string', 'max:255'],

            'artificial_inseminations' => ['nullable', 'array'],
            'artificial_inseminations.*.beneficiary_name' => ['required_with:artificial_inseminations.*', 'string', 'max:255'],
            'artificial_inseminations.*.address' => ['nullable', 'string', 'max:255'],
            'artificial_inseminations.*.vaccinated_count' => ['nullable', 'integer', 'min:0'],
            'artificial_inseminations.*.species' => ['nullable', 'string', 'max:100'],
            'artificial_inseminations.*.insemination_date' => ['nullable', 'date'],

            'poultry_followups' => ['nullable', 'array'],
            'poultry_followups.*.breeder_name' => ['required_with:poultry_followups.*', 'string', 'max:255'],
            'poultry_followups.*.address' => ['nullable', 'string', 'max:255'],
            'poultry_followups.*.bird_type' => ['nullable', 'string', 'max:150'],
            'poultry_followups.*.visit_date' => ['nullable', 'date'],
            'poultry_followups.*.detected_diseases' => ['nullable', 'string', 'max:500'],
            'poultry_followups.*.treatment_used' => ['nullable', 'string', 'max:500'],
            'poultry_followups.*.applied_vaccines' => ['nullable', 'string', 'max:500'],
            'poultry_followups.*.notes' => ['nullable', 'string', 'max:1000'],

            'beekeeping_followups' => ['nullable', 'array'],
            'beekeeping_followups.*.breeder_name' => ['required_with:beekeeping_followups.*', 'string', 'max:255'],
            'beekeeping_followups.*.address' => ['nullable', 'string', 'max:255'],
            'beekeeping_followups.*.diseases' => ['nullable', 'string', 'max:500'],
            'beekeeping_followups.*.applied_treatment' => ['nullable', 'string', 'max:500'],
            'beekeeping_followups.*.hive_count' => ['nullable', 'integer', 'min:0'],

            'other_infectious_diseases' => ['nullable', 'array'],
            'other_infectious_diseases.*.species' => ['required_with:other_infectious_diseases.*', Rule::in(['cattle', 'sheep', 'goats', 'camels', 'rabbits', 'birds', 'bees'])],
            'other_infectious_diseases.*.diseases' => ['nullable', 'array'],
            'other_infectious_diseases.*.diseases.*' => ['nullable', 'string', 'max:255'],
            'other_infectious_diseases.*.custom_diseases' => ['nullable', 'string', 'max:1000'],

            'medicines_and_vaccines' => ['nullable', 'array'],
            'medicines_and_vaccines.*.category' => ['required_with:medicines_and_vaccines.*', Rule::in(['vaccines', 'antibiotics', 'anti_inflammatory', 'antiparasitic', 'other'])],
            'medicines_and_vaccines.*.medicines' => ['nullable', 'array'],
            'medicines_and_vaccines.*.medicines.*' => ['nullable', 'string', 'max:255'],
            'medicines_and_vaccines.*.custom_medicines' => ['nullable', 'string', 'max:1000'],
            'medicines_and_vaccines.*.item_name' => ['nullable', 'string', 'max:255'],
            'medicines_and_vaccines.*.quantity' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}

