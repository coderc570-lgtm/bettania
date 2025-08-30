<?php

namespace App\Http\Controllers;

use App\Http\Requests\FabricSeason\Create;
use App\Http\Requests\FabricSeason\Destroy;
use App\Http\Requests\FabricSeason\Edit;
use App\Http\Requests\FabricSeason\ForceDelete;
use App\Http\Requests\FabricSeason\Index;
use App\Http\Requests\FabricSeason\Restore;
use App\Http\Requests\FabricSeason\Show;
use App\Http\Requests\FabricSeason\Store;
use App\Http\Requests\FabricSeason\Update;
use App\Repositories\FabricSeasonRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FabricSeasonController extends Controller
{
    protected FabricSeasonRepository $FabricSeasonRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(FabricSeasonRepository $FabricSeasonRepository)
    {
        $this->FabricSeasonRepository = $FabricSeasonRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricSeasonRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->FabricSeasonRepository->create();
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricSeasonRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->FabricSeasonRepository->show($id, $this->selected_relation_columns_only);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->FabricSeasonRepository->edit($id, $this->selected_relation_columns_only);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricSeasonRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->FabricSeasonRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->FabricSeasonRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->FabricSeasonRepository->restore($id, $this->selected_relation_columns_only);
        return $this->FabricSeasonRepository->getJsonResponse($data);
    }
}
