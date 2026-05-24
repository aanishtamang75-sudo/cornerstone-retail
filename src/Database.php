<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function init(array $config): void
    {
        if (self::$pdo !== null) {
            return;
        }
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['dbname'],
            $config['charset']
        );
        try {
            self::$pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            if (\app_config('debug')) {
                throw $e;
            }
            http_response_code(503);
            exit('Database connection failed. Import database/schema.sql and check config/database.php');
        }
    }

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            throw new \RuntimeException('Database not initialized');
        }
        return self::$pdo;
    }
}
