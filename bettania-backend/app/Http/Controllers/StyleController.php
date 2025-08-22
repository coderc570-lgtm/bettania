<?php

namespace App\Http\Controllers;

use App\Http\Requests\Style\Create;
use App\Http\Requests\Style\Destroy;
use App\Http\Requests\Style\Edit;
use App\Http\Requests\Style\ForceDelete;
use App\Http\Requests\Style\Index;
use App\Http\Requests\Style\Restore;
use App\Http\Requests\Style\Show;
use App\Http\Requests\Style\Store;
use App\Http\Requests\Style\Update;
use App\Repositories\StyleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class StyleController extends Controller
{
    protected StyleRepository $StyleRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(StyleRepository $StyleRepository)
    {
        $this->StyleRepository = $StyleRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->StyleRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->StyleRepository->create();
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->StyleRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->StyleRepository->show($id, $this->selected_relation_columns_only);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->StyleRepository->edit($id, $this->selected_relation_columns_only);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->StyleRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->StyleRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->StyleRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->StyleRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->StyleRepository->restore($id, $this->selected_relation_columns_only);
        return $this->StyleRepository->getJsonResponse($data);
    }
}