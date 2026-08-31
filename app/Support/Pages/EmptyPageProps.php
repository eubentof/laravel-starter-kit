<?php

namespace App\Support\Pages;

final readonly class EmptyPageProps extends PageProps
{
    /** @param array<string, mixed> $data */
    public static function fromArray(array $data = []): self
    {
        return new self;
    }
}
