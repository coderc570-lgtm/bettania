<?php

namespace App\Http\Controllers;

use App\Http\Requests\FabricMaterial\Create;
use App\Http\Requests\FabricMaterial\Destroy;
use App\Http\Requests\FabricMaterial\Edit;
use App\Http\Requests\FabricMaterial\ForceDelete;
use App\Http\Requests\FabricMaterial\Index;
use App\Http\Requests\FabricMaterial\Restore;
use App\Http\Requests\FabricMaterial\Show;
use App\Http\Requests\FabricMaterial\Store;
use App\Http\Requests\FabricMaterial\Update;
use App\Repositories\FabricMaterialRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FabricMaterialController extends Controller
{
    protected FabricMaterialRepository $FabricMaterialRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(FabricMaterialRepository $FabricMaterialRepository)
    {
        $this->FabricMaterialRepository = $FabricMaterialRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricMaterialRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->FabricMaterialRepository->create();
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricMaterialRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->FabricMaterialRepository->show($id, $this->selected_relation_columns_only);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->FabricMaterialRepository->edit($id, $this->selected_relation_columns_only);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricMaterialRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->FabricMaterialRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->FabricMaterialRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->FabricMaterialRepository->restore($id, $this->selected_relation_columns_only);
        return $this->FabricMaterialRepository->getJsonResponse($data);
    }
}
