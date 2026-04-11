<?php

namespace App\DTO;

class DistrictDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
        );
    }
}
