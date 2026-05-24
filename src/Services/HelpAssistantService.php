<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Rule-based help assistant using curated FAQ (no external API / no PII).
 */
final class HelpAssistantService
{
    /** @var list<array{keywords: list<string>, answer: string}> */
    private array $faq;

    public function __construct()
    {
        $path = BASE_PATH . '/data/faq.json';
        $json = is_file($path) ? file_get_contents($path) : '[]';
        $this->faq = json_decode($json ?: '[]', true, 512, JSON_THROW_ON_ERROR);
    }

    public function answer(string $question): array
    {
        $q = strtolower(trim($question));
        if ($q === '') {
            return [
                'answer' => 'Please enter a question about the shop system (orders, products, account, etc.).',
                'matched' => false,
                'source' => 'system',
            ];
        }

        $best = null;
        $bestScore = 0;
        foreach ($this->faq as $entry) {
            $score = 0;
            foreach ($entry['keywords'] as $kw) {
                if (str_contains($q, strtolower($kw))) {
                    $score += 2;
                }
            }
            if (preg_match('/\b(' . implode('|', array_map('preg_quote', $entry['keywords'])) . ')\b/i', $question)) {
                $score += 1;
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $entry;
            }
        }

        if ($best && $bestScore > 0) {
            return [
                'answer' => $best['answer'],
                'matched' => true,
                'source' => 'faq',
                'topic' => $best['topic'] ?? 'general',
            ];
        }

        return [
            'answer' => 'I could not find a specific answer. Try asking about: placing orders, order status, '
                . 'product search, admin product management, or AI description assistant. '
                . 'Contact shop admin for account issues.',
            'matched' => false,
            'source' => 'fallback',
        ];
    }
}
