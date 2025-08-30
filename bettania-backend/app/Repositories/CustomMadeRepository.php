<?php

namespace App\Repositories;

use App\Models\CustomMade;
use App\Traits\QueryGenerator;

class CustomMadeRepository
{
    use QueryGenerator;

    protected CustomMade $model;

    public function __construct(CustomMade $model)
    {
        $this->model = $model;
    }

//    public function index($payload, $selected_relation_columns_only = [], $headers = []): array
//    {
//        // override parent method here;
//    }
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
