<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fabric\Create;
use App\Http\Requests\Fabric\Destroy;
use App\Http\Requests\Fabric\Edit;
use App\Http\Requests\Fabric\ForceDelete;
use App\Http\Requests\Fabric\Index;
use App\Http\Requests\Fabric\Restore;
use App\Http\Requests\Fabric\Show;
use App\Http\Requests\Fabric\Store;
use App\Http\Requests\Fabric\Update;
use App\Repositories\FabricRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FabricController extends Controller
{
    protected FabricRepository $FabricRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

   public function __construct(FabricRepository $FabricRepository)
   {
       $this->FabricRepository = $FabricRepository;
   }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->FabricRepository->create();
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->FabricRepository->show($id, $this->selected_relation_columns_only);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->FabricRepository->edit($id, $this->selected_relation_columns_only);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->FabricRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->FabricRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->FabricRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->FabricRepository->restore($id, $this->selected_relation_columns_only);
        return $this->FabricRepository->getJsonResponse($data);
    }
}