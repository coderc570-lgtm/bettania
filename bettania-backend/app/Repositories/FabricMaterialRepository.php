<?php

namespace App\Repositories;

use App\Models\FabricMaterial;
use App\Traits\QueryGenerator;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Str;

class FabricMaterialRepository
{
    use QueryGenerator;

    protected FabricMaterial $model;

    public function __construct(FabricMaterial $model)
    {
        $this->model = $model;
    }

    public function index($payload, $selected_relation_columns_only = [], $headers = [],): array
    {
        $excludedIds = $payload['excluded_id'] ?? null;

        $tableName = $this->model->getTable();
        $query = $this->model::query();
        $ability = Str::plural(str_replace('_', '-', Str::snake($tableName)));

        // Get relations of the current table
        $foreignRelations = $this->getForeignTableRelations($tableName);
        $allTables = array_merge([['local' => null, 'table' => $tableName, 'foreign' => null, 'table_alias' => null]], $foreignRelations);

        // Generate selects based on foreign tables and selected columns
        $selects = $this->generateSelects($allTables, $selected_relation_columns_only);
        if (!empty($selects)) {
            $query->select($selects['selects']);
        }

        // Apply joins for foreign tables via separate function
        $this->applyLeftJoins($query, $foreignRelations, $tableName);

        $this->addJsonAggregation($query, [
            'name' => 'sub_fabric_materials.title'
        ], 'sub_fabric_materials.id', 'sub_fabric_materials');

        $query->leftJoin('fabric_materials as sub_fabric_materials', function ($join) {
            $join->on('fabric_materials.id', '=', 'sub_fabric_materials.head_fabric_material_id')
                ->whereNull('sub_fabric_materials.deleted_at');
        });

        // Exclude specific IDs if provided
        if ($excludedIds) {
            $query->whereNotIn("{$tableName}.id", $excludedIds);
        }

        // Handle search filters
        $this->search($payload, $query, $selects);
        $this->searchGlobal($payload, $query, $selects);

        $query->groupBy([
            'fabric_materials.id',
            'fabric_materials_head_fabric_material_id_foreign.id',
        ]);

        // Apply ordering
        foreach ($this->orderBy($payload) as $order) {
            $query->orderBy($order['order_by'], $order['sort_order']);
        }

        // Get total count for pagination
        $total = $query->count();

        // Apply pagination logic
        $pagination = $this->paginate($payload, $total);
        $list = $query->skip($pagination['skip'])->take($pagination['take'])->get();
        $list->transform(function ($item) {
            $item->sub_fabric_materials = $item->sub_fabric_materials ? json_decode($item->sub_fabric_materials, true) : null;
            return $item;
        });

        // Return if no results found
        if ($list->isEmpty()) {
            return [
                'message' => 'No results found.',
                'error' => null,
                'current_page' => 0,
                'from' => 0,
                'to' => 0,
                'last_page' => 0,
                'skip' => 0,
                'take' => 0,
                'total' => 0,
                'headers' => $headers,
                'body' => [],
                'searchable' => $selects['columns']
            ];
        }

        // Calculate last page
        $lastPage = ($pagination['take'] > 0) ? ceil($total / $pagination['take']) : 1;

        return [
            'message' => 'These are the results.',
            'error' => null,
            'current_page' => $pagination['current_page'],
            'from' => $pagination['skip'] + 1,
            'to' => min(($pagination['skip'] + $pagination['take']), $total),
            'last_page' => (int)$lastPage,
            'skip' => $pagination['skip'],
            'take' => $pagination['take'],
            'total' => $total,
            'headers' => $headers,
            'body' => $list,
            'searchable' => $selects['columns']
        ];
    }
//
//    public function create(): array
//    {
//        // override parent method here;
//    }
//
//    public function store($payload): array
//    {
//        // override parent method here;
//    }
//
//    public function show($id): array
//    {
//        // override parent method here;
//    }
//
//    public function edit($id): array
//    {
//        // override parent method here;
//    }
//
//    public function update($payload, $id): array
//    {
//        // override parent method here;
//    }
//
//    public function destroy($id): array
//    {
//        // override parent method here;
//    }
//
//    public function forceDelete($id): array
//    {
//        // override parent method here;
//    }
//
//    public function restore($id): array
//    {
//        // override parent method here;
//    }
}