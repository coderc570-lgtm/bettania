<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trouser\Create;
use App\Http\Requests\Trouser\Destroy;
use App\Http\Requests\Trouser\Edit;
use App\Http\Requests\Trouser\ForceDelete;
use App\Http\Requests\Trouser\Index;
use App\Http\Requests\Trouser\Restore;
use App\Http\Requests\Trouser\Show;
use App\Http\Requests\Trouser\Store;
use App\Http\Requests\Trouser\Update;
use App\Repositories\TrouserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TrouserController extends Controller
{
    protected TrouserRepository $TrouserRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(TrouserRepository $TrouserRepository)
    {
        $this->TrouserRepository = $TrouserRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TrouserRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->TrouserRepository->create();
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TrouserRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->TrouserRepository->show($id, $this->selected_relation_columns_only);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->TrouserRepository->edit($id, $this->selected_relation_columns_only);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TrouserRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->TrouserRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->TrouserRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->TrouserRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->TrouserRepository->restore($id, $this->selected_relation_columns_only);
        return $this->TrouserRepository->getJsonResponse($data);
    }
}
