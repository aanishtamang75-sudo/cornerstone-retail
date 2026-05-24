<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Database;

final class AdminController
{
    public function activityLog(): void
    {
        Auth::requireAdmin();
        $stmt = Database::pdo()->query(
            'SELECT a.*, u.full_name, u.email FROM activity_log a
             LEFT JOIN users u ON u.id = a.user_id
             ORDER BY a.created_at DESC LIMIT 100'
        );
        view('admin.activity', [
            'title' => 'Activity log',
            'entries' => $stmt->fetchAll(),
        ]);
    }

    public function aiLog(): void
    {
        Auth::requireAdmin();
        $stmt = Database::pdo()->query(
            'SELECT l.*, u.full_name FROM ai_suggestion_log l
             JOIN users u ON u.id = l.user_id
             ORDER BY l.created_at DESC LIMIT 50'
        );
        view('admin.ai_log', [
            'title' => 'AI suggestion log',
            'entries' => $stmt->fetchAll(),
        ]);
    }
}
