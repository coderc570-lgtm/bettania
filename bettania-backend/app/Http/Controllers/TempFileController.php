<?php

namespace App\Http\Controllers;

use App\Http\Requests\TempFile\Upload;
use App\Http\Requests\TempFile\UploadFile;
use App\Repositories\TempFileRepository;
use Illuminate\Http\JsonResponse;

class TempFileController extends Controller
{
    protected TempFileRepository $TempFileRepository;
    protected array $selected_relation_columns_only = [
//            "suppliers_encoded_by_foreign" => ['id', 'first_name', 'middle_name', 'last_name', 'email']
        ];
    protected array $headers = [
//            ['text' => 'Supplier', 'value' => 'suppliers_name', 'align' => 'left', 'sortable' => false],
        ];

    public function __construct(TempFileRepository $TempFileRepository)
    {
        $this->TempFileRepository = $TempFileRepository;
    }

    // public function index(Index $request): JsonResponse
    // {
    //     $payload = $request->validated();
    //     $data = $this->TempFileRepository->index($payload, $this->selected_relation_columns_only, $this->headers);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function create(Create $request): JsonResponse
    // {
    //     $data = $this->TempFileRepository->create();
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function store(Store $request): JsonResponse
    // {
    //     $payload = $request->validated();
    //     $data = $this->TempFileRepository->store($payload, $this->selected_relation_columns_only, $this->headers);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function show(Show $request, $id): JsonResponse
    // {
    //     $data = $this->TempFileRepository->show($id, $this->selected_relation_columns_only);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function edit(Edit $request, $id): JsonResponse
    // {
    //     $data = $this->TempFileRepository->edit($id, $this->selected_relation_columns_only);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function update(Update $request, $id): JsonResponse
    // {
    //     $payload = $request->validated();
    //     $data = $this->TempFileRepository->update($payload, $id, $this->selected_relation_columns_only, $this->headers);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function destroy(Destroy $request, $id): JsonResponse
    // {
    //     $data = $this->TempFileRepository->destroy($id, $this->selected_relation_columns_only);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function forceDelete(ForceDelete $request, $id): JsonResponse
    // {
    //     $data = $this->TempFileRepository->forceDelete($id, $this->selected_relation_columns_only);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    // public function restore(Restore $request, $id): JsonResponse
    // {
    //     $data = $this->TempFileRepository->restore($id, $this->selected_relation_columns_only);
    //     return $this->TempFileRepository->getJsonResponse($data);
    // }

    public function upload(Upload $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TempFileRepository->upload($payload);
        return $this->TempFileRepository->getJsonResponse($data);
    }

    public function uploadFile(UploadFile $request): JsonResponse
    {
        $payload = $request->validated();
        $data = $this->TempFileRepository->uploadFile($payload);
        return $this->TempFileRepository->getJsonResponse($data);
    }
}