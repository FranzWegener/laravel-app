<?php

declare(strict_types=1);

namespace App\Modules\Documents\Domain;

class Document
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {
    }
}
