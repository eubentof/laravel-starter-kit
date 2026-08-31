<?php

namespace App\DataTables;

use App\DataTables\Enums\FilterType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

abstract class DataTable
{
    abstract public function schema(): DataTableSchemaData;

    /** @return Builder<covariant Model> */
    abstract protected function query(): Builder;

    /** @return LengthAwarePaginator<int, Model> */
    public function paginate(Request $request): LengthAwarePaginator
    {
        $schema = $this->schema();
        $columns = collect($schema->columns)->keyBy('field');
        $validated = validator($request->all(), [
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'sort_field' => ['nullable', Rule::in($columns->filter->sortable->keys()->all())],
            'sort_direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'filters' => ['sometimes', 'array'],
        ])->validate();

        $query = $this->query();

        foreach ($validated['filters'] ?? [] as $field => $value) {
            $column = $columns->get($field);
            if (! $column instanceof DataTableColumnData || $column->filter === null || $value === null || $value === '') {
                continue;
            }

            $this->applyFilter($query, $column, $value);
        }

        $sortField = $validated['sort_field'] ?? $schema->defaultSortField;
        $sortDirection = $validated['sort_direction'] ?? $schema->defaultSortDirection;
        if ($sortField !== null && $columns->get($sortField)?->sortable) {
            $query->orderBy($sortField, $sortDirection);
        }

        return $query->paginate($validated['per_page'] ?? $schema->perPage);
    }

    /** @param Builder<covariant Model> $query */
    protected function applyFilter(Builder $query, DataTableColumnData $column, mixed $value): void
    {
        $filter = $column->filter;
        if ($filter === null) {
            return;
        }

        match ($filter) {
            FilterType::Text => $query->where($column->field, 'like', '%'.str_replace(['%', '_'], ['\\%', '\\_'], (string) $value).'%'),
            FilterType::Number, FilterType::Select => $query->where($column->field, $value),
            FilterType::DateRange, FilterType::Range => $query->whereBetween($column->field, [$value[0], $value[1]]),
        };
    }
}
