<?php

declare(strict_types=1);

namespace App;

final class ActivityLogger
{
    public static function log(string $action, string $entityType, ?int $entityId = null, ?string $details = null): void
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO activity_log (user_id, action, entity_type, entity_id, details) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([Auth::id(), $action, $entityType, $entityId, $details]);
    }
}
