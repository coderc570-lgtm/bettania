<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaistCoat\Create;
use App\Http\Requests\WaistCoat\Destroy;
use App\Http\Requests\WaistCoat\Edit;
use App\Http\Requests\WaistCoat\ForceDelete;
use App\Http\Requests\WaistCoat\Index;
use App\Http\Requests\WaistCoat\Restore;
use App\Http\Requests\WaistCoat\Show;
use App\Http\Requests\WaistCoat\Store;
use App\Http\Requests\WaistCoat\Update;
use App\Repositories\WaistCoatRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class WaistCoatController extends Controller
{
    protected WaistCoatRepository $WaistCoatRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(WaistCoatRepository $WaistCoatRepository)
    {
        $this->WaistCoatRepository = $WaistCoatRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->WaistCoatRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->WaistCoatRepository->create();
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->WaistCoatRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->WaistCoatRepository->show($id, $this->selected_relation_columns_only);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->WaistCoatRepository->edit($id, $this->selected_relation_columns_only);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->WaistCoatRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->WaistCoatRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->WaistCoatRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->WaistCoatRepository->restore($id, $this->selected_relation_columns_only);
        return $this->WaistCoatRepository->getJsonResponse($data);
    }
}
