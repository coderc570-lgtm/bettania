<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Traits\QueryGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartRepository
{
    use QueryGenerator;

    protected Cart $model;

    public function __construct(Cart $model)
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
            'cart_id' => 'carts.id',
            'fabric_id' => 'fabrics.id',
            'style_id' => 'styles.id',
            'trouser_fabric_id' => 'trouser_fabrics.id',
            'button_id' => 'buttons.id',
            'internal_lining_id' => 'internal_linings.id',
            'lapel_id' => 'lapels.id',
            'price' => 'cart_items.price',
            'quantity' => 'cart_items.quantity',
        ], 'cart_items.id', 'cart_items');

        $query->leftJoin('cart_items', function ($join) {
            $join->on('carts.id', '=', 'cart_items.cart_id')
                ->whereNull('cart_items.deleted_at');
        });

        // Exclude specific IDs if provided
        if ($excludedIds) {
            $query->whereNotIn("{$tableName}.id", $excludedIds);
        }

        // Handle search filters
        $this->search($payload, $query, $selects);
        $this->searchGlobal($payload, $query, $selects);

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
            $item->cart_items = $item->cart_items ? json_decode($item->cart_items, true) : [];
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
    public function store($payload, $selected_relation_columns_only = [], $headers = []): array
    {
        DB::beginTransaction();
        try {
            $data = $this->model::firstOrCreate(
                [
                    'user_id' => Auth::id() ?? null,
                    'token'   => $this->getCartToken(),
                ]
            );

            $data->cartItems()->createMany($payload['cart_items'] ?? []);

            $model_name = $this->model->getTable();

            $result = $this->index(['search' => [['key' => "$model_name.id", 's' => $data['id'],]]], $selected_relation_columns_only, $headers);

            if ($result['body'])
                $result['message'] = 'Successfully created.';

            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            // Please review the Logs if there are errors.
            return [
                'message' => 'An error occurred while storing.',
                'error' => $exception->getMessage(),
                'status' => 422
            ];
        }
    }
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

    public function guestIndex($payload, $selected_relation_columns_only = [], $headers = []): array
    {
        $payload['search'][] = [
            'key' => 'carts.token',
            's' => $this->getCartToken(),
        ];

        return $this->index($payload, $selected_relation_columns_only, $headers);
    }

    private function getCartToken()
    {
        return request()->cookie('cart_token') 
            ?? tap(Str::uuid(), fn($uuid) => cookie()->queue('cart_token', $uuid, 60*24*30)); 
    }
}