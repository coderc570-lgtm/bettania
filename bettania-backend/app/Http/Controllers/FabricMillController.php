<?php

namespace App\Http\Controllers;

use App\Http\Requests\FabricMill\Create;
use App\Http\Requests\FabricMill\Destroy;
use App\Http\Requests\FabricMill\Edit;
use App\Http\Requests\FabricMill\ForceDelete;
use App\Http\Requests\FabricMill\Index;
use App\Http\Requests\FabricMill\Restore;
use App\Http\Requests\FabricMill\Show;
use App\Http\Requests\FabricMill\Store;
use App\Http\Requests\FabricMill\Update;
use App\Repositories\FabricMillRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FabricMillController extends Controller
{
    protected FabricMillRepository $FabricMillRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(FabricMillRepository $FabricMillRepository)
    {
        $this->FabricMillRepository = $FabricMillRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricMillRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->FabricMillRepository->create();
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricMillRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->FabricMillRepository->show($id, $this->selected_relation_columns_only);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->FabricMillRepository->edit($id, $this->selected_relation_columns_only);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricMillRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->FabricMillRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->FabricMillRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->FabricMillRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->FabricMillRepository->restore($id, $this->selected_relation_columns_only);
        return $this->FabricMillRepository->getJsonResponse($data);
    }
}
