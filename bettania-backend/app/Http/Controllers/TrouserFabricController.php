<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrouserFabric\Create;
use App\Http\Requests\TrouserFabric\Destroy;
use App\Http\Requests\TrouserFabric\Edit;
use App\Http\Requests\TrouserFabric\ForceDelete;
use App\Http\Requests\TrouserFabric\Index;
use App\Http\Requests\TrouserFabric\Restore;
use App\Http\Requests\TrouserFabric\Show;
use App\Http\Requests\TrouserFabric\Store;
use App\Http\Requests\TrouserFabric\Update;
use App\Repositories\TrouserFabricRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TrouserFabricController extends Controller
{
    protected TrouserFabricRepository $TrouserFabricRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(TrouserFabricRepository $TrouserFabricRepository)
    {
        $this->TrouserFabricRepository = $TrouserFabricRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TrouserFabricRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->TrouserFabricRepository->create();
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TrouserFabricRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->TrouserFabricRepository->show($id, $this->selected_relation_columns_only);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->TrouserFabricRepository->edit($id, $this->selected_relation_columns_only);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TrouserFabricRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->TrouserFabricRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->TrouserFabricRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->TrouserFabricRepository->restore($id, $this->selected_relation_columns_only);
        return $this->TrouserFabricRepository->getJsonResponse($data);
    }
}
