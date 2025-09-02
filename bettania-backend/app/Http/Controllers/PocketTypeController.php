<?php

namespace App\Http\Controllers;

use App\Http\Requests\PocketType\Create;
use App\Http\Requests\PocketType\Destroy;
use App\Http\Requests\PocketType\Edit;
use App\Http\Requests\PocketType\ForceDelete;
use App\Http\Requests\PocketType\Index;
use App\Http\Requests\PocketType\Restore;
use App\Http\Requests\PocketType\Show;
use App\Http\Requests\PocketType\Store;
use App\Http\Requests\PocketType\Update;
use App\Repositories\PocketTypeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PocketTypeController extends Controller
{
    protected PocketTypeRepository $PocketTypeRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(PocketTypeRepository $PocketTypeRepository)
    {
        $this->PocketTypeRepository = $PocketTypeRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PocketTypeRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->PocketTypeRepository->create();
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PocketTypeRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->PocketTypeRepository->show($id, $this->selected_relation_columns_only);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->PocketTypeRepository->edit($id, $this->selected_relation_columns_only);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PocketTypeRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->PocketTypeRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->PocketTypeRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->PocketTypeRepository->restore($id, $this->selected_relation_columns_only);
        return $this->PocketTypeRepository->getJsonResponse($data);
    }
}
