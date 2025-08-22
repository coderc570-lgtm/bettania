<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    protected $signature = 'app:module {name}';
    protected $description = 'Generate Controller, Requests, and Repository for a model';

    public function handle(): int
    {
        $name = Str::studly($this->argument('name')); 
        $namespace = "App\\Http\\Requests\\{$name}";
        $controllerNamespace = "App\\Http\\Controllers";
        $repositoryNamespace = "App\\Repositories";

        // === 1. Create Controller ===
        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");
        File::ensureDirectoryExists(dirname($controllerPath));
        $controllerStub = File::get(base_path('stubs/controller.stub'));

        $controllerContent = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ model }}', '{{ rootNamespace }}'],
            [$controllerNamespace, "{$name}Controller", $name, "App\\"],
            $controllerStub
        );

        File::put($controllerPath, $controllerContent);
        $this->info("✅ Created Controller: {$controllerPath}");

        // === 2. Create Requests ===
        $requests = ['Index', 'Create', 'Store', 'Show', 'Edit', 'Update', 'Destroy', 'ForceDelete', 'Restore'];
        $requestStub = File::get(base_path('stubs/request.stub'));

        $requestFolder = app_path("Http/Requests/{$name}");
        File::ensureDirectoryExists($requestFolder);

        foreach ($requests as $req) {
            $requestClass = $req;
            $requestPath = "{$requestFolder}/{$req}.php";

            $requestContent = str_replace(
                ['{{ namespace }}', '{{ class }}'],
                [$namespace, $req],
                $requestStub
            );

            File::put($requestPath, $requestContent);
            $this->info("✅ Created Request: {$requestPath}");
        }

        // === 3. Create Repository ===
        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        File::ensureDirectoryExists(app_path("Repositories"));
        $repositoryStub = File::get(base_path('stubs/repository.stub'));

        $repositoryContent = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$repositoryNamespace, $name],
            $repositoryStub
        );

        File::put($repositoryPath, $repositoryContent);
        $this->info("✅ Created Repository: {$repositoryPath}");

        $this->info("🎉 {$name} module created successfully!");
        return self::SUCCESS;
    }
}