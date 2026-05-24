<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Local drafting assistant — templates + keyword enrichment (no external LLM / no PII).
 * User must review and edit before saving (human-in-the-loop).
 */
final class DescriptionAssistantService
{
    public function suggest(string $name, string $notes, string $category = ''): string
    {
        $name = trim($name);
        $notes = trim($notes);
        $category = trim($category);

        $tone = 'Discover ';
        $features = [];

        if (preg_match('/\b(set|pack|box|bundle)\b/i', $name)) {
            $features[] = 'convenient multi-piece value';
        }
        if (preg_match('/\b(mug|candle|chocolate|gift)\b/i', $name . ' ' . $notes)) {
            $features[] = 'ideal for gifting';
        }
        if (preg_match('/\b(linen|cotton|wool|ceramic|leather)\b/i', $name . ' ' . $notes)) {
            $features[] = 'quality materials';
        }
        if (preg_match('/\b(dishwasher|machine wash|washable)\b/i', $notes)) {
            $features[] = 'easy care';
        }

        $featureText = $features !== []
            ? implode(', ', $features) . '. '
            : 'Thoughtfully selected for everyday use. ';

        $categoryPhrase = $category !== '' ? " From our {$category} range." : '';

        $body = $notes !== ''
            ? $this->polishNotes($notes)
            : 'A customer favourite from our local retail collection.';

        return $tone . $name . ' — ' . $featureText . $body . $categoryPhrase
            . ' Available while stocks last at Cornerstone Retail.';
    }

    private function polishNotes(string $notes): string
    {
        $notes = preg_replace('/\s+/', ' ', $notes) ?? $notes;
        $notes = ucfirst(strtolower($notes));
        if (!str_ends_with($notes, '.')) {
            $notes .= '.';
        }
        return $notes;
    }
}
