<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\HelpAssistantService;

final class HelpController
{
    public function index(): void
    {
        view('help.index', ['title' => 'Help assistant']);
    }

    public function ask(): void
    {
        $question = trim($_POST['question'] ?? $_GET['question'] ?? '');
        $service = new HelpAssistantService();
        $result = $service->answer($question);

        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            json_response($result);
        }

        view('help.index', [
            'title' => 'Help assistant',
            'question' => $question,
            'result' => $result,
        ]);
    }
}
