<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TempFileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /**
     * Public routes (no auth middleware)
     */

    Route::prefix('sign-up')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::patch('/update/{id}', [UserController::class, 'update']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthenticationController::class, 'register']);
        Route::post('/login', [AuthenticationController::class, 'login']);
        Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgotPassword');
        Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::get('/check', [AuthenticationController::class, 'checkAuth']);
    });

    Route::get('/guest-cart', [CartController::class, 'guestIndex']);
    Route::post('/guest-add-cart', [CartController::class, 'store']);
    Route::post('/request-login', [AuthenticationController::class, 'requestLoginCode']);
    Route::post('/authenticate', [AuthenticationController::class, 'authenticate']);

    /**
     * Protected routes (require Sanctum)
     */
    Route::middleware('auth:sanctum')->group(function () {
        // current user
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Auto-routing for controllers
        $controller_directory = app_path('Http/Controllers');
        $controller_files = scandir($controller_directory);
        $excluded_controllers = ['Auth', 'Report', 'TempFile', 'SessionAgendaChanges', 'Mail', 'SearchEngine', 'Attachment', 'ApplicationSignatory', 'Dashboard', 'Authentication']; // remove post name 'Controller in adding excluded controllers

        foreach ($controller_files as $controller_file) {
            if (is_file($controller_directory . '/' . $controller_file)) {
                // Remove the ".php" extension and "Controller" postfix
                $controller_name = pathinfo($controller_file, PATHINFO_FILENAME);
                $name_case = str_replace('Controller', '', $controller_name);

                if ($name_case != "" && !in_array($name_case, $excluded_controllers)) {
                    // Transform the name into your desired format
                    $name = Str::plural(Str::snake($name_case));
                    $slug = Str::plural(Str::snake($name_case, '-'));

                    $controller = [
                        'controller' => 'App\\Http\\Controllers\\' . $controller_name,
                        'slug' => $slug,
                        'name' => $name
                    ];

                    Route::controller(app($controller['controller'])::class)->group(function () use ($controller, $name_case) {

                        Route::match(['POST'], $controller['slug'], 'index')->name($controller['slug'] . '.index');
                        Route::post($controller['slug'] . '/create', 'create')->name($controller['slug'] . '.create');
                        Route::match(['GET', 'POST'], $controller['slug'] . '/edit' . '/{' . $controller['name'] . '}', 'edit')->name($controller['slug'] . '.edit');
                        Route::post($controller['slug'] . '/store', 'store')->name($controller['slug'] . '.store');
                        Route::match(['GET', 'POST'], $controller['slug'] . '/show/{' . $controller['name'] . '}', 'show')->name($controller['slug'] . '.show');
                        Route::match(['PUT', 'PATCH'], $controller['slug'] . '/{' . $controller['name'] . '}', 'update')->name($controller['slug'] . '.update');

                        // if the model uses soft-deletes enable these routes.
                        if (class_exists('App\\Models\\' . $name_case) && in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses('App\\Models\\' . $name_case))) {
                            Route::delete($controller['slug'] . '/delete/{' . $controller['name'] . '}', 'destroy')->name($controller['slug'] . '.destroy');
                            // disabled at the moment
                            // Route::post($controller['slug'] . '/{' . $controller['name'] . '}' . '/restore', 'restore')->name($controller['slug'] . '.restore');
                        }

                        /*  TODO NEED TO RE-ASSIST THIS ROUTE SINCE NOT ALL CONTROLLERS NEED UPLOAD.
                            for now this is just temporary.
                        */
                        Route::post($controller['slug'] . '/upload', 'upload')->name($controller['slug'] . '.upload');
                        // disabled at the moment
                        // Route::match(['GET','POST'], $controller['slug'].'/export'.'/{'.$controller['name'].'}', 'export')->name($controller['slug'].'.export');
                    });
                }
            }
        }

        // Custom routes go here - add them manually as needed

        // FILE UPLOADS
        Route::post('uploads/temp-file', [TempFileController::class, 'upload']);
        Route::post('uploads/file', [TempFileController::class, 'uploadFile']);
    });
});