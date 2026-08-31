<?php

namespace App\Support\Actions;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class HandledBy
{
    /** @param class-string<ActionHandler> $handler */
    public function __construct(public string $handler) {}
}
