<?php

namespace App\Http\Controllers;

use App\Http\Requests\Closure\Create;
use App\Http\Requests\Closure\Destroy;
use App\Http\Requests\Closure\Edit;
use App\Http\Requests\Closure\ForceDelete;
use App\Http\Requests\Closure\Index;
use App\Http\Requests\Closure\Restore;
use App\Http\Requests\Closure\Show;
use App\Http\Requests\Closure\Store;
use App\Http\Requests\Closure\Update;
use App\Repositories\ClosureRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ClosureController extends Controller
{
    protected ClosureRepository $ClosureRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(ClosureRepository $ClosureRepository)
    {
        $this->ClosureRepository = $ClosureRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ClosureRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->ClosureRepository->create();
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ClosureRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->ClosureRepository->show($id, $this->selected_relation_columns_only);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->ClosureRepository->edit($id, $this->selected_relation_columns_only);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->ClosureRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->ClosureRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->ClosureRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->ClosureRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->ClosureRepository->restore($id, $this->selected_relation_columns_only);
        return $this->ClosureRepository->getJsonResponse($data);
    }
}
