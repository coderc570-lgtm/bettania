<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomMade\Create;
use App\Http\Requests\CustomMade\Destroy;
use App\Http\Requests\CustomMade\Edit;
use App\Http\Requests\CustomMade\ForceDelete;
use App\Http\Requests\CustomMade\Index;
use App\Http\Requests\CustomMade\Restore;
use App\Http\Requests\CustomMade\Show;
use App\Http\Requests\CustomMade\Store;
use App\Http\Requests\CustomMade\Update;
use App\Repositories\CustomMadeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CustomMadeController extends Controller
{
    protected CustomMadeRepository $CustomMadeRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(CustomMadeRepository $CustomMadeRepository)
    {
        $this->CustomMadeRepository = $CustomMadeRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CustomMadeRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->CustomMadeRepository->create();
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CustomMadeRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->CustomMadeRepository->show($id, $this->selected_relation_columns_only);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->CustomMadeRepository->edit($id, $this->selected_relation_columns_only);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CustomMadeRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->CustomMadeRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->CustomMadeRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->CustomMadeRepository->restore($id, $this->selected_relation_columns_only);
        return $this->CustomMadeRepository->getJsonResponse($data);
    }
}
