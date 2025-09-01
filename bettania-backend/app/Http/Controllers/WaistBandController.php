<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaistBand\Create;
use App\Http\Requests\WaistBand\Destroy;
use App\Http\Requests\WaistBand\Edit;
use App\Http\Requests\WaistBand\ForceDelete;
use App\Http\Requests\WaistBand\Index;
use App\Http\Requests\WaistBand\Restore;
use App\Http\Requests\WaistBand\Show;
use App\Http\Requests\WaistBand\Store;
use App\Http\Requests\WaistBand\Update;
use App\Repositories\WaistBandRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class WaistBandController extends Controller
{
    protected WaistBandRepository $WaistBandRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(WaistBandRepository $WaistBandRepository)
    {
        $this->WaistBandRepository = $WaistBandRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->WaistBandRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->WaistBandRepository->create();
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->WaistBandRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->WaistBandRepository->show($id, $this->selected_relation_columns_only);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->WaistBandRepository->edit($id, $this->selected_relation_columns_only);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->WaistBandRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->WaistBandRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->WaistBandRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->WaistBandRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->WaistBandRepository->restore($id, $this->selected_relation_columns_only);
        return $this->WaistBandRepository->getJsonResponse($data);
    }
}
