<?php

namespace App\Repositories;

use App\Models\TempFile;
use App\Services\FileUploadService;
use App\Traits\QueryGenerator;
use Illuminate\Support\Facades\DB;

class TempFileRepository
{
    use QueryGenerator;

    protected TempFile $model;

    public function __construct(TempFile $model)
    {
        $this->model = $model;
    }

//    public function index($request, $selected_relation_columns_only = [], $headers = []): array
//    {
//        // override parent method here;
//    }
//
//    public function create(): array
//    {
//        // override parent method here;
//    }
//
//    public function store($request): array
//    {
//        // override parent method here;
//    }
//
//    public function show($id): array
//    {
//        // override parent method here;
//    }
//
//    public function edit($id): array
//    {
//        // override parent method here;
//    }
//
//    public function update($request, $id): array
//    {
//        // override parent method here;
//    }
//
//    public function destroy($id): array
//    {
//        // override parent method here;
//    }
//
//    public function forceDelete($id): array
//    {
//        // override parent method here;
//    }
//
//    public function restore($id): array
//    {
//        // override parent method here;
//    }

    public function upload($request): array
    {
        $model_name = $this->model->getTable();

        DB::beginTransaction();
        try {
            if (isset($request['file'])) {
                $file_upload = new FileUploadService;
                $path = $file_upload->upload($request['file'], $model_name);

                // Explode the string by '/'
                $arrays = explode('/', $path);
                $path = $arrays[2];
                $file_name = pathinfo($path, PATHINFO_FILENAME);

                logger()->info($path);
                $request['filepath'] = $path;
            }
            $payloads = $request;
            unset($payloads['file']);

            # create the TempFile data
            $data = $this->model::create($payloads);

            $result = $this->index(['search' => [['key' => "$model_name.id", 's' => $data['id'],]]], [], []);
            $result['body'][0]['file_name'] = $file_name;
            $result['message'] = 'Successfully upload file.';
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // Please review the Logs if there are errors.
            return [
                'message' => 'An error occurred while updating.',
                'error' => $exception->getMessage(),
                'status' => 422
            ];
        }

        return $result;
    }

    public function uploadFile($request): array
    {
        $folder_name = $request['folder_name'] ?? 'default_lts_files';

        DB::beginTransaction();
        try {
            if (isset($request['file'])) {
                $file_upload = new FileUploadService;
                $file_path = $file_upload->upload($request['file'], $folder_name);

                // Explode the string by '/'
                $arrays = explode('/', $file_path);
                $path = $arrays[3];
                $file_name = pathinfo($path, PATHINFO_FILENAME);

                logger()->info($path);
                $request['filepath'] = $path;
            }
            $payloads = $request;
            unset($payloads['file']);

            $result['body']['file_path'] = $file_path;
            $result['body']['file_name'] = $file_name;
            $result['body']['original_file_name'] = $request['file']->getClientOriginalName();
            $result['message'] = 'Successfully upload file.';
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // Please review the Logs if there are errors.
            return [
                'message' => 'An error occurred while updating.',
                'error' => $exception->getMessage(),
                'status' => 422
            ];
        }

        return $result;
    }
}