<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItem\Create;
use App\Http\Requests\CartItem\Destroy;
use App\Http\Requests\CartItem\Edit;
use App\Http\Requests\CartItem\ForceDelete;
use App\Http\Requests\CartItem\Index;
use App\Http\Requests\CartItem\Restore;
use App\Http\Requests\CartItem\Show;
use App\Http\Requests\CartItem\Store;
use App\Http\Requests\CartItem\Update;
use App\Repositories\CartItemRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CartItemController extends Controller
{
    protected CartItemRepository $CartItemRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(CartItemRepository $CartItemRepository)
    {
        $this->CartItemRepository = $CartItemRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CartItemRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->CartItemRepository->create();
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CartItemRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->CartItemRepository->show($id, $this->selected_relation_columns_only);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->CartItemRepository->edit($id, $this->selected_relation_columns_only);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->CartItemRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->CartItemRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->CartItemRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->CartItemRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->CartItemRepository->restore($id, $this->selected_relation_columns_only);
        return $this->CartItemRepository->getJsonResponse($data);
    }
}
