<?php

namespace App\Service;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidGenerator
{
    public function getUuid(): UuidInterface
    {
        return Uuid::uuid4();
    }

    public function getUuidShort(): string
    {
        return $this->encode(
            Uuid::uuid4()->toString()
        );
    }

    private function encode(string $uuid): string
    {
        return $this->gmpBaseConvert(str_replace('-', '', $uuid));
    }

    private function gmpBaseConvert(string $value): string
    {
        return gmp_strval(gmp_init($value, 16), 62);
    }
}
