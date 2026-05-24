<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;

final class ProductModel
{
    public static function paginated(array $filters, int $page, int $perPage): array
    {
        $where = ['1=1'];
        $params = [];

        if ($filters['q'] !== '') {
            $where[] = '(p.name LIKE ? OR p.sku LIKE ? OR p.description LIKE ?)';
            $like = '%' . $filters['q'] . '%';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }
        if ($filters['category_id'] !== '') {
            $where[] = 'p.category_id = ?';
            $params[] = (int) $filters['category_id'];
        }
        if ($filters['min_price'] !== '') {
            $where[] = 'p.price >= ?';
            $params[] = (float) $filters['min_price'];
        }
        if ($filters['max_price'] !== '') {
            $where[] = 'p.price <= ?';
            $params[] = (float) $filters['max_price'];
        }
        if ($filters['in_stock'] === '1') {
            $where[] = 'p.stock > 0';
        }

        $whereSql = implode(' AND ', $where);
        $countStmt = Database::pdo()->prepare(
            "SELECT COUNT(*) FROM products p WHERE $whereSql"
        );
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $offset = max(0, ($page - 1) * $perPage);
        $sql = "SELECT p.*, c.name AS category_name,
                u1.full_name AS created_by_name, u2.full_name AS updated_by_name
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN users u1 ON u1.id = p.created_by
                LEFT JOIN users u2 ON u2.id = p.updated_by
                WHERE $whereSql
                ORDER BY p.name ASC
                LIMIT $perPage OFFSET $offset";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             LEFT JOIN categories c ON c.id = p.category_id WHERE p.id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data, int $userId): int
    {
        $stmt = Database::pdo()->prepare(
            'INSERT INTO products (category_id, name, sku, description, price, stock, image_url, created_by, updated_by)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['category_id'] ?: null,
            $data['name'],
            $data['sku'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['image_url'] ?: null,
            $userId,
            $userId,
        ]);
        return (int) Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data, int $userId): void
    {
        $stmt = Database::pdo()->prepare(
            'UPDATE products SET category_id=?, name=?, sku=?, description=?, price=?, stock=?, image_url=?, updated_by=? WHERE id=?'
        );
        $stmt->execute([
            $data['category_id'] ?: null,
            $data['name'],
            $data['sku'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['image_url'] ?: null,
            $userId,
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::pdo()->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function skuExists(string $sku, ?int $excludeId = null): bool
    {
        $sql = 'SELECT 1 FROM products WHERE sku = ?';
        $params = [strtoupper(trim($sku))];
        if ($excludeId) {
            $sql .= ' AND id != ?';
            $params[] = $excludeId;
        }
        $stmt = Database::pdo()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }
}
