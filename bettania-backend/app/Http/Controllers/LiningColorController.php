<?php

namespace App\Http\Controllers;

use App\Http\Requests\LiningColor\Create;
use App\Http\Requests\LiningColor\Destroy;
use App\Http\Requests\LiningColor\Edit;
use App\Http\Requests\LiningColor\ForceDelete;
use App\Http\Requests\LiningColor\Index;
use App\Http\Requests\LiningColor\Restore;
use App\Http\Requests\LiningColor\Show;
use App\Http\Requests\LiningColor\Store;
use App\Http\Requests\LiningColor\Update;
use App\Repositories\LiningColorRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LiningColorController extends Controller
{
    protected LiningColorRepository $LiningColorRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(LiningColorRepository $LiningColorRepository)
    {
        $this->LiningColorRepository = $LiningColorRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->LiningColorRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->LiningColorRepository->create();
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->LiningColorRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->LiningColorRepository->show($id, $this->selected_relation_columns_only);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->LiningColorRepository->edit($id, $this->selected_relation_columns_only);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->LiningColorRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->LiningColorRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->LiningColorRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->LiningColorRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->LiningColorRepository->restore($id, $this->selected_relation_columns_only);
        return $this->LiningColorRepository->getJsonResponse($data);
    }
}
