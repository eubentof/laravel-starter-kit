<?php

namespace App\DataTables;

use App\DataTables\Enums\CellType;
use App\DataTables\Enums\FilterType;
use App\Support\Data\DataObject;

final readonly class DataTableColumnData extends DataObject
{
    public function __construct(
        public string $field,
        public string $label,
        public CellType $cell = CellType::Text,
        public ?FilterType $filter = null,
        public bool $sortable = false,
        public bool $editable = false,
        public bool $visible = true,
        public bool $pinned = false,
        public ?string $provider = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            field: $data['field'],
            label: $data['label'],
            cell: CellType::from($data['cell'] ?? CellType::Text->value),
            filter: isset($data['filter']) ? FilterType::from($data['filter']) : null,
            sortable: $data['sortable'] ?? false,
            editable: $data['editable'] ?? false,
            visible: $data['visible'] ?? true,
            pinned: $data['pinned'] ?? false,
            provider: $data['provider'] ?? null,
        );
    }
}
