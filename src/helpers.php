<?php

declare(strict_types=1);

function app_config(string $key, mixed $default = null): mixed
{
    static $config;
    $config ??= require BASE_PATH . '/config/app.php';
    return $config[$key] ?? $default;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function url(string $route, array $query = []): string
{
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    $path = $base . '/index.php?route=' . rawurlencode($route);
    if ($query !== []) {
        $path .= '&' . http_build_query($query);
    }
    return $path;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }
    $val = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $val;
}

function old(string $key, string $default = ''): string
{
    return e($_SESSION['_old'][$key] ?? $default);
}

function set_old(array $data): void
{
    $_SESSION['_old'] = $data;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): bool
{
    $token = $_POST['_csrf'] ?? '';
    return is_string($token) && hash_equals(csrf_token(), $token);
}

function view(string $name, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $viewFile = BASE_PATH . '/views/' . str_replace('.', '/', $name) . '.php';
    if (!is_file($viewFile)) {
        http_response_code(500);
        echo 'View not found: ' . e($name);
        return;
    }
    require BASE_PATH . '/views/layout/header.php';
    require $viewFile;
    require BASE_PATH . '/views/layout/footer.php';
}

function json_response(array $data, int $code = 200): never
{
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data, JSON_THROW_ON_ERROR);
    exit;
}

/** Public URL for a product image (upload path or external URL). */
function product_image_src(?string $imageUrl): ?string
{
    if ($imageUrl === null || trim($imageUrl) === '') {
        return null;
    }
    $imageUrl = trim($imageUrl);
    if (str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://')) {
        return $imageUrl;
    }
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    return $base . '/' . ltrim($imageUrl, '/');
}
