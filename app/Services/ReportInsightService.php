<?php

namespace App\Services;

use App\Models\MonthlyReport;
use Illuminate\Support\Facades\Http;

class ReportInsightService
{
    public function generateSummary(MonthlyReport $report): string
    {
        $apiKey = config('services.openai.key');

        if ($apiKey) {
            $remoteSummary = $this->generateWithApi($report, $apiKey);

            if ($remoteSummary !== null) {
                return $remoteSummary;
            }
        }

        return $this->generateFallbackSummary($report);
    }

    private function generateWithApi(MonthlyReport $report, string $apiKey): ?string
    {
        $baseUrl = rtrim(config('services.openai.base_url', 'https://api.openai.com/v1'), '/');
        $model = config('services.openai.model', 'gpt-4o-mini');

        $prompt = [
            'language' => app()->getLocale() === 'fr' ? 'French' : 'Arabic',
            'task' => 'Produce a concise analytical executive summary of this veterinary monthly report. Mention unusual disease trends, vaccination coverage, and operational recommendations.',
            'report' => [
                'year' => $report->report_year,
                'month' => $report->report_month,
                'notifiable_diseases' => $report->notifiable_diseases,
                'lab_requests' => $report->lab_requests,
                'rabies_vaccination' => $report->rabies_vaccination,
                'sheep_pox_vaccination' => $report->sheep_pox_vaccination,
                'fmd_vaccination' => $report->fmd_vaccination,
                'enterotoxemia_vaccination' => $report->enterotoxemia_vaccination,
                'pet_vaccinations' => $report->pet_vaccinations,
                'parasite_treatments' => $report->parasite_treatments,
                'artificial_inseminations' => $report->artificial_inseminations,
                'poultry_followups' => $report->poultry_followups,
                'beekeeping_followups' => $report->beekeeping_followups,
                'other_infectious_diseases' => $report->other_infectious_diseases,
                'medicines_and_vaccines' => $report->medicines_and_vaccines,
                'suggestions' => $report->suggestions,
            ],
        ];

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post("{$baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a veterinary analytics assistant. Keep the summary structured and practical.',
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode($prompt, JSON_UNESCAPED_UNICODE),
                    ],
                ],
                'temperature' => 0.2,
            ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json('choices.0.message.content');
    }

    private function generateFallbackSummary(MonthlyReport $report): string
    {
        $notifiableCount = count($report->notifiable_diseases ?? []);
        $labCount = count($report->lab_requests ?? []);
        $petVaccinated = collect($report->pet_vaccinations ?? [])->sum(fn ($item) => (int) ($item['count'] ?? 0));
        $parasiteTreatments = collect($report->parasite_treatments ?? [])->sum(fn ($item) => (int) ($item['count'] ?? 0));

        if (app()->getLocale() === 'fr') {
            return "Synthese IA automatique:\n- Cas de maladies a declaration obligatoire: {$notifiableCount}.\n- Demandes d'analyses en laboratoire: {$labCount}.\n- Animaux de compagnie vaccines: {$petVaccinated}.\n- Traitements antiparasitaires realises: {$parasiteTreatments}.\nRecommandation: renforcer le suivi preventif dans les elevages presentant des cas repetitifs et cibler des campagnes de sensibilisation mensuelles.";
        }

        return "حوصلة ذكاء اصطناعي تلقائية:\n- عدد حالات الأمراض ذات التصريح الإجباري: {$notifiableCount}.\n- عدد طلبات التحاليل المخبرية: {$labCount}.\n- مجموع الحيوانات الأليفة الملقحة: {$petVaccinated}.\n- مجموع العلاجات المضادة للطفيليات المنجزة: {$parasiteTreatments}.\nتوصية: تعزيز المتابعة الوقائية في البؤر المتكررة وتكثيف حملات التوعية الشهرية.";
    }
}
