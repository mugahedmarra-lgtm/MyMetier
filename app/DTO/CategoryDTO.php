<?php

namespace App\DTO;

class CategoryDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $icon = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['icon'] ?? null,
        );
    }
}
