<?php

namespace App\Http\Controllers;

use App\Http\Requests\Button\Create;
use App\Http\Requests\Button\Destroy;
use App\Http\Requests\Button\Edit;
use App\Http\Requests\Button\ForceDelete;
use App\Http\Requests\Button\Index;
use App\Http\Requests\Button\Restore;
use App\Http\Requests\Button\Show;
use App\Http\Requests\Button\Store;
use App\Http\Requests\Button\Update;
use App\Repositories\ButtonRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ButtonController extends Controller
{
    protected ButtonRepository $ButtonRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(ButtonRepository $ButtonRepository)
    {
        $this->ButtonRepository = $ButtonRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ButtonRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->ButtonRepository->create();
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ButtonRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->ButtonRepository->show($id, $this->selected_relation_columns_only);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->ButtonRepository->edit($id, $this->selected_relation_columns_only);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ButtonRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->ButtonRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->ButtonRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->ButtonRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->ButtonRepository->restore($id, $this->selected_relation_columns_only);
        return $this->ButtonRepository->getJsonResponse($data);
    }
}
