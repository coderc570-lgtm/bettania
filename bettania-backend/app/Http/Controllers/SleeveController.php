<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sleeve\Create;
use App\Http\Requests\Sleeve\Destroy;
use App\Http\Requests\Sleeve\Edit;
use App\Http\Requests\Sleeve\ForceDelete;
use App\Http\Requests\Sleeve\Index;
use App\Http\Requests\Sleeve\Restore;
use App\Http\Requests\Sleeve\Show;
use App\Http\Requests\Sleeve\Store;
use App\Http\Requests\Sleeve\Update;
use App\Repositories\SleeveRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class SleeveController extends Controller
{
    protected SleeveRepository $SleeveRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(SleeveRepository $SleeveRepository)
    {
        $this->SleeveRepository = $SleeveRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->SleeveRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->SleeveRepository->create();
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->SleeveRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->SleeveRepository->show($id, $this->selected_relation_columns_only);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->SleeveRepository->edit($id, $this->selected_relation_columns_only);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->SleeveRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->SleeveRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->SleeveRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->SleeveRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->SleeveRepository->restore($id, $this->selected_relation_columns_only);
        return $this->SleeveRepository->getJsonResponse($data);
    }
}
