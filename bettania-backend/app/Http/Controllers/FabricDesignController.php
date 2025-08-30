<?php

namespace App\Http\Controllers;

use App\Http\Requests\FabricDesign\Create;
use App\Http\Requests\FabricDesign\Destroy;
use App\Http\Requests\FabricDesign\Edit;
use App\Http\Requests\FabricDesign\ForceDelete;
use App\Http\Requests\FabricDesign\Index;
use App\Http\Requests\FabricDesign\Restore;
use App\Http\Requests\FabricDesign\Show;
use App\Http\Requests\FabricDesign\Store;
use App\Http\Requests\FabricDesign\Update;
use App\Repositories\FabricDesignRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FabricDesignController extends Controller
{
    protected FabricDesignRepository $FabricDesignRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(FabricDesignRepository $FabricDesignRepository)
    {
        $this->FabricDesignRepository = $FabricDesignRepository;
    }

    public function index(Index $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricDesignRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function create(Create $request): JsonResponse
    {
        $data = $this->FabricDesignRepository->create();
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function store(Store $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricDesignRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function show(Show $request, $id): JsonResponse
    {
        $data = $this->FabricDesignRepository->show($id, $this->selected_relation_columns_only);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function edit(Edit $request, $id): JsonResponse
    {
        $data = $this->FabricDesignRepository->edit($id, $this->selected_relation_columns_only);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function update(Update $request, $id): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->FabricDesignRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function destroy(Destroy $request, $id): JsonResponse
    {
        $data = $this->FabricDesignRepository->destroy($id, $this->selected_relation_columns_only);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function forceDelete(ForceDelete $request, $id): JsonResponse
    {
        $data = $this->FabricDesignRepository->forceDelete($id, $this->selected_relation_columns_only);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }

    public function restore(Restore $request, $id): JsonResponse
    {
        $data = $this->FabricDesignRepository->restore($id, $this->selected_relation_columns_only);
        return $this->FabricDesignRepository->getJsonResponse($data);
    }
}