<?php

declare(strict_types=1);

namespace App;

final class Auth
{
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int
    {
        return isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function isAdmin(): bool
    {
        return (self::user()['role'] ?? '') === 'admin';
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
        ];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            flash('error', 'Please log in to continue.');
            redirect(url('login'));
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            flash('error', 'Admin access required.');
            redirect(url('products.index'));
        }
    }
}
