<?php

namespace App\Http\Controllers;

use App\Http\Requests\BackStyle\Create;
use App\Http\Requests\BackStyle\Destroy;
use App\Http\Requests\BackStyle\Edit;
use App\Http\Requests\BackStyle\ForceDelete;
use App\Http\Requests\BackStyle\Index;
use App\Http\Requests\BackStyle\Restore;
use App\Http\Requests\BackStyle\Show;
use App\Http\Requests\BackStyle\Store;
use App\Http\Requests\BackStyle\Update;
use App\Repositories\BackStyleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BackStyleController extends Controller
{
    protected BackStyleRepository $BackStyleRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(BackStyleRepository $BackStyleRepository)
    {
        $this->BackStyleRepository = $BackStyleRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->BackStyleRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->BackStyleRepository->create();
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->BackStyleRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->BackStyleRepository->show($id, $this->selected_relation_columns_only);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->BackStyleRepository->edit($id, $this->selected_relation_columns_only);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->BackStyleRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->BackStyleRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->BackStyleRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->BackStyleRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->BackStyleRepository->restore($id, $this->selected_relation_columns_only);
        return $this->BackStyleRepository->getJsonResponse($data);
    }
}
