<?php

// Connects this routes file to the TaskController class, so routes below can send
// matching /api/tasks requests to methods like index(), store(), show(), update(), and destroy().
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Creates the task API endpoints and sends each request to TaskController:
// GET /api/tasks -> index(), POST /api/tasks -> store(), GET /api/tasks/{task} -> show(),
// PUT/PATCH /api/tasks/{task} -> update(), DELETE /api/tasks/{task} -> destroy().
Route::apiResource('tasks', TaskController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
