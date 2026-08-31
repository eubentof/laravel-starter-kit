<?php

namespace App\DataTables;

use InvalidArgumentException;

final class DataTableRegistry
{
    /** @var array<string, class-string<DataTable>> */
    private array $tables = [];

    /** @param class-string<DataTable> $table */
    public function register(string $name, string $table): void
    {
        $this->tables[$name] = $table;
    }

    public function resolve(string $name): DataTable
    {
        $table = $this->tables[$name] ?? null;

        if ($table === null) {
            throw new InvalidArgumentException("Unknown data table [{$name}].");
        }

        return app($table);
    }
}
