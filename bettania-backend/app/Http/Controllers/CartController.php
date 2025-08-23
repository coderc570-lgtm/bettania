<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\Create;
use App\Http\Requests\Cart\Destroy;
use App\Http\Requests\Cart\Edit;
use App\Http\Requests\Cart\ForceDelete;
use App\Http\Requests\Cart\Index;
use App\Http\Requests\Cart\Restore;
use App\Http\Requests\Cart\Show;
use App\Http\Requests\Cart\Store;
use App\Http\Requests\Cart\Update;
use App\Repositories\CartRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected CartRepository $CartRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(CartRepository $CartRepository)
    {
        $this->CartRepository = $CartRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CartRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->CartRepository->create();
        return $this->CartRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CartRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->CartRepository->show($id, $this->selected_relation_columns_only);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->CartRepository->edit($id, $this->selected_relation_columns_only);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CartRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->CartRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->CartRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->CartRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->CartRepository->restore($id, $this->selected_relation_columns_only);
        return $this->CartRepository->getJsonResponse($data);
    }
}
