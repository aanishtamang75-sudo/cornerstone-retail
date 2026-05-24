<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;
use App\Models\AiLogModel;
use App\Models\CategoryModel;
use App\Services\DescriptionAssistantService;

final class AiController
{
    public function suggestDescription(): void
    {
        Auth::requireAdmin();
        $name = trim($_POST['name'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $category = '';
        foreach (CategoryModel::all() as $c) {
            if ((int) $c['id'] === $categoryId) {
                $category = $c['name'];
                break;
            }
        }

        $service = new DescriptionAssistantService();
        $suggested = $service->suggest($name, $notes, $category);

        if (Auth::id()) {
            AiLogModel::log(Auth::id(), 'description_draft', $notes, $suggested, null, false);
        }

        json_response([
            'suggested' => $suggested,
            'disclaimer' => app_config('ai_disclaimer'),
        ]);
    }

    public function logAcceptance(): void
    {
        Auth::requireAdmin();
        if (!verify_csrf()) {
            json_response(['ok' => false], 400);
        }
        $suggested = trim($_POST['suggested'] ?? '');
        $accepted = trim($_POST['accepted'] ?? '');
        $input = trim($_POST['input'] ?? '');
        $wasAccepted = $suggested !== '' && $accepted !== '';

        if (Auth::id()) {
            AiLogModel::log(
                Auth::id(),
                'description_draft',
                $input,
                $suggested,
                $accepted,
                $wasAccepted && similar_text($suggested, $accepted) > 0
            );
        }
        json_response(['ok' => true]);
    }
}
