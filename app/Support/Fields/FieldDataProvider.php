<?php

namespace App\Support\Fields;

abstract class FieldDataProvider
{
    abstract public static function key(): string;

    /** @return list<FieldOptionData> */
    abstract public function options(?string $search, int $page, int $perPage): array;

    abstract public function hasMore(?string $search, int $page, int $perPage): bool;

    /** @param list<string|int> $values
     * @return list<FieldOptionData>
     */
    abstract public function resolve(array $values): array;
}
