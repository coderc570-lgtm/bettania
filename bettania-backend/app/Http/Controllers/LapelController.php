<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lapel\Create;
use App\Http\Requests\Lapel\Destroy;
use App\Http\Requests\Lapel\Edit;
use App\Http\Requests\Lapel\ForceDelete;
use App\Http\Requests\Lapel\Index;
use App\Http\Requests\Lapel\Restore;
use App\Http\Requests\Lapel\Show;
use App\Http\Requests\Lapel\Store;
use App\Http\Requests\Lapel\Update;
use App\Repositories\LapelRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LapelController extends Controller
{
    protected LapelRepository $LapelRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(LapelRepository $LapelRepository)
    {
        $this->LapelRepository = $LapelRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->LapelRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->LapelRepository->create();
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->LapelRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->LapelRepository->show($id, $this->selected_relation_columns_only);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->LapelRepository->edit($id, $this->selected_relation_columns_only);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->LapelRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->LapelRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->LapelRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->LapelRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->LapelRepository->restore($id, $this->selected_relation_columns_only);
        return $this->LapelRepository->getJsonResponse($data);
    }
}
