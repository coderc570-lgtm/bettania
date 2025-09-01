<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pleat\Create;
use App\Http\Requests\Pleat\Destroy;
use App\Http\Requests\Pleat\Edit;
use App\Http\Requests\Pleat\ForceDelete;
use App\Http\Requests\Pleat\Index;
use App\Http\Requests\Pleat\Restore;
use App\Http\Requests\Pleat\Show;
use App\Http\Requests\Pleat\Store;
use App\Http\Requests\Pleat\Update;
use App\Repositories\PleatRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PleatController extends Controller
{
    protected PleatRepository $PleatRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(PleatRepository $PleatRepository)
    {
        $this->PleatRepository = $PleatRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PleatRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->PleatRepository->create();
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PleatRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->PleatRepository->show($id, $this->selected_relation_columns_only);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->PleatRepository->edit($id, $this->selected_relation_columns_only);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->PleatRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->PleatRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->PleatRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->PleatRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->PleatRepository->restore($id, $this->selected_relation_columns_only);
        return $this->PleatRepository->getJsonResponse($data);
    }
}
