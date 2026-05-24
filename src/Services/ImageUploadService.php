<?php

declare(strict_types=1);

namespace App\Services;

final class ImageUploadService
{
    private const MAX_BYTES = 2_097_152; // 2 MB
    private const ALLOWED_MIME = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    public static function uploadDir(): string
    {
        return PUBLIC_PATH . '/assets/uploads/products';
    }

    /** @return string Relative path stored in DB (under public/) */
    public static function store(array $file): string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            throw new \InvalidArgumentException('No image file uploaded.');
        }
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new \InvalidArgumentException('Image upload failed. Try a smaller file.');
        }
        if (($file['size'] ?? 0) > self::MAX_BYTES) {
            throw new \InvalidArgumentException('Image must be 2 MB or smaller.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!is_string($mime) || !isset(self::ALLOWED_MIME[$mime])) {
            throw new \InvalidArgumentException('Only JPG, PNG, WebP, and GIF images are allowed.');
        }

        $ext = self::ALLOWED_MIME[$mime];
        $dir = self::uploadDir();
        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new \RuntimeException('Could not create upload directory.');
        }

        $name = bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
        $dest = $dir . DIRECTORY_SEPARATOR . $name;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            throw new \RuntimeException('Could not save uploaded image.');
        }

        return 'assets/uploads/products/' . $name;
    }

    public static function deleteIfLocal(?string $imageUrl): void
    {
        if ($imageUrl === null || $imageUrl === '' || self::isExternalUrl($imageUrl)) {
            return;
        }
        $path = PUBLIC_PATH . '/' . ltrim(str_replace(['../', '..\\'], '', $imageUrl), '/\\');
        if (is_file($path)) {
            @unlink($path);
        }
    }

    public static function isExternalUrl(string $value): bool
    {
        return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
    }
}
