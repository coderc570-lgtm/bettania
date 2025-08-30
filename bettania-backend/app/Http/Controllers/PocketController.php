<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pocket\Create;
use App\Http\Requests\Pocket\Destroy;
use App\Http\Requests\Pocket\Edit;
use App\Http\Requests\Pocket\ForceDelete;
use App\Http\Requests\Pocket\Index;
use App\Http\Requests\Pocket\Restore;
use App\Http\Requests\Pocket\Show;
use App\Http\Requests\Pocket\Store;
use App\Http\Requests\Pocket\Update;
use App\Repositories\PocketRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PocketController extends Controller
{
    protected PocketRepository $PocketRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(PocketRepository $PocketRepository)
    {
        $this->PocketRepository = $PocketRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PocketRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->PocketRepository->create();
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PocketRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->PocketRepository->show($id, $this->selected_relation_columns_only);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->PocketRepository->edit($id, $this->selected_relation_columns_only);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PocketRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->PocketRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->PocketRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->PocketRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->PocketRepository->restore($id, $this->selected_relation_columns_only);
        return $this->PocketRepository->getJsonResponse($data);
    }
}
