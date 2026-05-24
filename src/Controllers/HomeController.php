<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Auth;

final class HomeController
{
    public function index(): void
    {
        if (Auth::check()) {
            redirect(url('products.index'));
        }
        redirect(url('login'));
    }
}
