<?php

namespace App\Http\Controllers;

use App\Http\Requests\InternalLining\Create;
use App\Http\Requests\InternalLining\Destroy;
use App\Http\Requests\InternalLining\Edit;
use App\Http\Requests\InternalLining\ForceDelete;
use App\Http\Requests\InternalLining\Index;
use App\Http\Requests\InternalLining\Restore;
use App\Http\Requests\InternalLining\Show;
use App\Http\Requests\InternalLining\Store;
use App\Http\Requests\InternalLining\Update;
use App\Repositories\InternalLiningRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class InternalLiningController extends Controller
{
    protected InternalLiningRepository $InternalLiningRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(InternalLiningRepository $InternalLiningRepository)
    {
        $this->InternalLiningRepository = $InternalLiningRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->InternalLiningRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->InternalLiningRepository->create();
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->InternalLiningRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->InternalLiningRepository->show($id, $this->selected_relation_columns_only);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->InternalLiningRepository->edit($id, $this->selected_relation_columns_only);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->InternalLiningRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->InternalLiningRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->InternalLiningRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->InternalLiningRepository->restore($id, $this->selected_relation_columns_only);
        return $this->InternalLiningRepository->getJsonResponse($data);
    }
}
