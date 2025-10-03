<?php

namespace App\ValueObjects;

class PostStatus
{
    public const PUBLISHED = 'published';
    public const DRAFT = 'draft';
    public const ARCHIVED = 'archived';
    public const PENDING = 'pending';
    public const SCHEDULED = 'scheduled';

    private string $status;

    public function __construct(string $status)
    {
        if (!in_array($status, self::validStatuses())) {
            throw new \InvalidArgumentException("Invalid post status: {$status}");
        }

        $this->status = $status;
    }

    public static function validStatuses(): array
    {
        return [
            self::PUBLISHED,
            self::DRAFT,
            self::ARCHIVED,
            self::PENDING,
            self::SCHEDULED,
        ];
    }

    public static function from(string $status): self
    {
        return new self($status);
    }

    public function value(): string
    {
        return $this->status;
    }

    public static function published(): self
    {
        return new self(self::PUBLISHED);
    }

    public static function draft(): self
    {
        return new self(self::DRAFT);
    }

    public static function archived(): self
    {
        return new self(self::ARCHIVED);
    }

    public static function pending(): self
    {
        return new self(self::PENDING);
    }

    public static function scheduled(): self
    {
        return new self(self::SCHEDULED);
    }

    public function isPublished(): bool
    {
        return $this->status === self::PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::DRAFT;
    }
}
