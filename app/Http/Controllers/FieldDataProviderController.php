<?php

namespace App\Http\Controllers;

use App\Support\Fields\FieldDataProviderRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FieldDataProviderController
{
    public function __invoke(Request $request, string $provider, FieldDataProviderRegistry $registry): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'values' => ['sometimes', 'array'],
            'values.*' => ['string'],
        ]);
        $resolved = $registry->resolve($provider);

        if (isset($validated['values'])) {
            return response()->json(['data' => $resolved->resolve($validated['values']), 'hasMore' => false]);
        }

        $search = $validated['search'] ?? null;
        $page = $validated['page'] ?? 1;
        $perPage = $validated['per_page'] ?? 10;

        return response()->json([
            'data' => $resolved->options($search, $page, $perPage),
            'hasMore' => $resolved->hasMore($search, $page, $perPage),
        ]);
    }
}
