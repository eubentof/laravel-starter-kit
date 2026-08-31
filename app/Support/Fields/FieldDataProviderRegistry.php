<?php

namespace App\Support\Fields;

use InvalidArgumentException;

final class FieldDataProviderRegistry
{
    /** @var array<string, class-string<FieldDataProvider>> */
    private array $providers = [];

    /** @param class-string<FieldDataProvider> $provider */
    public function register(string $provider): void
    {
        $this->providers[$provider::key()] = $provider;
    }

    public function resolve(string $key): FieldDataProvider
    {
        $provider = $this->providers[$key] ?? null;

        if ($provider === null) {
            throw new InvalidArgumentException("Unknown field data provider [{$key}].");
        }

        return app($provider);
    }
}
