<?php

namespace App\Http\Controllers;

use App\Http\Requests\VShape\Create;
use App\Http\Requests\VShape\Destroy;
use App\Http\Requests\VShape\Edit;
use App\Http\Requests\VShape\ForceDelete;
use App\Http\Requests\VShape\Index;
use App\Http\Requests\VShape\Restore;
use App\Http\Requests\VShape\Show;
use App\Http\Requests\VShape\Store;
use App\Http\Requests\VShape\Update;
use App\Repositories\VShapeRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class VShapeController extends Controller
{
    protected VShapeRepository $VShapeRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(VShapeRepository $VShapeRepository)
    {
        $this->VShapeRepository = $VShapeRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->VShapeRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->VShapeRepository->create();
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->VShapeRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->VShapeRepository->show($id, $this->selected_relation_columns_only);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->VShapeRepository->edit($id, $this->selected_relation_columns_only);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->VShapeRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->VShapeRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->VShapeRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->VShapeRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->VShapeRepository->restore($id, $this->selected_relation_columns_only);
        return $this->VShapeRepository->getJsonResponse($data);
    }
}
