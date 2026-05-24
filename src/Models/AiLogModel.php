<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class AiLogModel
{
    public static function log(
        int $userId,
        string $feature,
        ?string $input,
        ?string $suggested,
        ?string $accepted,
        bool $wasAccepted
    ): void {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO ai_suggestion_log (user_id, feature, input_text, suggested_text, accepted_text, was_accepted)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $feature, $input, $suggested, $accepted, $wasAccepted ? 1 : 0]);
    }
}
