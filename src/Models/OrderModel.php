<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;
use PDO;

final class OrderModel
{
    public static function forUser(int $userId, bool $adminView = false): array
    {
        if ($adminView) {
            $sql = 'SELECT o.*, u.full_name AS customer_name, u.email AS customer_email
                    FROM orders o JOIN users u ON u.id = o.user_id ORDER BY o.created_at DESC';
            return Database::pdo()->query($sql)->fetchAll();
        }
        $stmt = Database::pdo()->prepare(
            'SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function find(int $id, ?int $userId = null, bool $admin = false): ?array
    {
        $sql = 'SELECT o.*, u.full_name AS customer_name, u.email AS customer_email
                FROM orders o JOIN users u ON u.id = o.user_id WHERE o.id = ?';
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([$id]);
        $order = $stmt->fetch();
        if (!$order) {
            return null;
        }
        if (!$admin && $userId !== null && (int) $order['user_id'] !== $userId) {
            return null;
        }
        $order['items'] = self::items((int) $id);
        return $order;
    }

    public static function items(int $orderId): array
    {
        $stmt = Database::pdo()->prepare(
            'SELECT oi.*, p.name AS product_name, p.sku FROM order_items oi
             JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?'
        );
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public static function create(int $userId, array $cart, ?string $notes, int $actorId): int
    {
        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO orders (user_id, status, total, notes, created_by, updated_by) VALUES (?, ?, 0, ?, ?, ?)'
            );
            $stmt->execute([$userId, 'pending', $notes, $actorId, $actorId]);
            $orderId = (int) $pdo->lastInsertId();
            $total = 0.0;

            $itemStmt = $pdo->prepare(
                'INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)'
            );
            $stockStmt = $pdo->prepare('UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?');

            foreach ($cart as $productId => $qty) {
                $product = ProductModel::find((int) $productId);
                if (!$product || (int) $product['stock'] < $qty) {
                    throw new \RuntimeException('Insufficient stock for ' . ($product['name'] ?? 'product'));
                }
                $line = (float) $product['price'] * $qty;
                $total += $line;
                $itemStmt->execute([$orderId, $productId, $qty, $product['price']]);
                $stockStmt->execute([$qty, $productId, $qty]);
                if ($stockStmt->rowCount() === 0) {
                    throw new \RuntimeException('Stock update failed');
                }
            }

            $pdo->prepare('UPDATE orders SET total = ? WHERE id = ?')->execute([$total, $orderId]);
            $pdo->commit();
            return $orderId;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function updateStatus(int $id, string $status, int $adminId): void
    {
        $stmt = Database::pdo()->prepare('UPDATE orders SET status = ?, updated_by = ? WHERE id = ?');
        $stmt->execute([$status, $adminId, $id]);
    }
}
