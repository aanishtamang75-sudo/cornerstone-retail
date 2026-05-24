<?php

declare(strict_types=1);

namespace App;

final class Validator
{
    /** @var array<string, string> */
    private array $errors = [];

    public function __construct(private array $data) {}

    public function required(string $field, string $label): self
    {
        $val = trim((string) ($this->data[$field] ?? ''));
        if ($val === '') {
            $this->errors[$field] = "$label is required.";
        }
        return $this;
    }

    public function email(string $field, string $label): self
    {
        $val = trim((string) ($this->data[$field] ?? ''));
        if ($val !== '' && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "$label must be a valid email.";
        }
        return $this;
    }

    public function minLen(string $field, int $min, string $label): self
    {
        $val = (string) ($this->data[$field] ?? '');
        if ($val !== '' && mb_strlen($val) < $min) {
            $this->errors[$field] = "$label must be at least $min characters.";
        }
        return $this;
    }

    public function numeric(string $field, string $label, float $min = 0): self
    {
        $val = $this->data[$field] ?? '';
        if (!is_numeric($val) || (float) $val < $min) {
            $this->errors[$field] = "$label must be a number ≥ $min.";
        }
        return $this;
    }

    public function integer(string $field, string $label, int $min = 0): self
    {
        $val = $this->data[$field] ?? '';
        if (!ctype_digit((string) $val) && !((is_int($val) || is_numeric($val)) && (int) $val >= $min)) {
            $this->errors[$field] = "$label must be a whole number ≥ $min.";
        }
        return $this;
    }

    public function inList(string $field, array $allowed, string $label): self
    {
        $val = $this->data[$field] ?? '';
        if ($val !== '' && !in_array($val, $allowed, true)) {
            $this->errors[$field] = "Invalid $label selected.";
        }
        return $this;
    }

    /** @return array<string, string> */
    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return $this->errors !== [];
    }
}
