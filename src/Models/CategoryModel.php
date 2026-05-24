<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class CategoryModel
{
    public static function all(): array
    {
        return Database::pdo()->query('SELECT * FROM categories ORDER BY name')->fetchAll();
    }
}
