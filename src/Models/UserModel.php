<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;
use PDO;

final class UserModel
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([strtolower(trim($email))]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::pdo()->prepare('SELECT id, email, full_name, role, created_at FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(string $email, string $password, string $fullName, string $role = 'user'): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = Database::pdo()->prepare(
            'INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([strtolower(trim($email)), $hash, trim($fullName), $role]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function all(): array
    {
        return Database::pdo()->query('SELECT id, email, full_name, role, created_at FROM users ORDER BY full_name')->fetchAll();
    }
}
