<?php

namespace App\Http\Controllers;

use App\DataTables\DataTableRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DataTableController
{
    public function __invoke(Request $request, string $table, DataTableRegistry $registry): JsonResponse
    {
        $resolved = $registry->resolve($table);

        return response()->json([
            'schema' => $resolved->schema(),
            'data' => $resolved->paginate($request),
        ]);
    }
}
