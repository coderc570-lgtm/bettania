<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClosureType\Create;
use App\Http\Requests\ClosureType\Destroy;
use App\Http\Requests\ClosureType\Edit;
use App\Http\Requests\ClosureType\ForceDelete;
use App\Http\Requests\ClosureType\Index;
use App\Http\Requests\ClosureType\Restore;
use App\Http\Requests\ClosureType\Show;
use App\Http\Requests\ClosureType\Store;
use App\Http\Requests\ClosureType\Update;
use App\Repositories\ClosureTypeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ClosureTypeController extends Controller
{
    protected ClosureTypeRepository $ClosureTypeRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(ClosureTypeRepository $ClosureTypeRepository)
    {
        $this->ClosureTypeRepository = $ClosureTypeRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ClosureTypeRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->ClosureTypeRepository->create();
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ClosureTypeRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->ClosureTypeRepository->show($id, $this->selected_relation_columns_only);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->ClosureTypeRepository->edit($id, $this->selected_relation_columns_only);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ClosureTypeRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->ClosureTypeRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->ClosureTypeRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->ClosureTypeRepository->restore($id, $this->selected_relation_columns_only);
        return $this->ClosureTypeRepository->getJsonResponse($data);
    }
}
