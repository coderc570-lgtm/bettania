<?php

namespace App\Http\Controllers;

use App\Http\Requests\Jacket\Create;
use App\Http\Requests\Jacket\Destroy;
use App\Http\Requests\Jacket\Edit;
use App\Http\Requests\Jacket\ForceDelete;
use App\Http\Requests\Jacket\Index;
use App\Http\Requests\Jacket\Restore;
use App\Http\Requests\Jacket\Show;
use App\Http\Requests\Jacket\Store;
use App\Http\Requests\Jacket\Update;
use App\Repositories\JacketRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class JacketController extends Controller
{
    protected JacketRepository $JacketRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(JacketRepository $JacketRepository)
    {
        $this->JacketRepository = $JacketRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->JacketRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->JacketRepository->create();
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->JacketRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->JacketRepository->show($id, $this->selected_relation_columns_only);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->JacketRepository->edit($id, $this->selected_relation_columns_only);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->JacketRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->JacketRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->JacketRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->JacketRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->JacketRepository->restore($id, $this->selected_relation_columns_only);
        return $this->JacketRepository->getJsonResponse($data);
    }
}
