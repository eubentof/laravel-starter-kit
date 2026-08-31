<?php

namespace App\DataTables;

use App\Support\Data\DataObject;

final readonly class DataTableSchemaData extends DataObject
{
    /** @param list<DataTableColumnData> $columns */
    public function __construct(
        public string $name,
        public array $columns,
        public string $rowKey = 'id',
        public int $perPage = 10,
        public ?string $defaultSortField = null,
        public string $defaultSortDirection = 'asc',
        public string $emptyTitle = 'No results found',
        public ?string $emptyDescription = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            columns: array_values(array_map(DataTableColumnData::fromArray(...), $data['columns'] ?? [])),
            rowKey: $data['rowKey'] ?? 'id',
            perPage: $data['perPage'] ?? 10,
            defaultSortField: $data['defaultSortField'] ?? null,
            defaultSortDirection: $data['defaultSortDirection'] ?? 'asc',
            emptyTitle: $data['emptyTitle'] ?? 'No results found',
            emptyDescription: $data['emptyDescription'] ?? null,
        );
    }
}
