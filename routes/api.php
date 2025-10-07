<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Public Routes
    Route::post('/admin/login', [AuthController::class, 'login']);

    // Protected Routes
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

        // Admin Logout
        Route::post('/admin/logout', [AuthController::class, 'logout']);

        // Student Routes
        Route::apiResource('students', StudentController::class);
        // This creates: GET /api/v1/students, POST /api/v1/students, etc.

        // Class Assignment Route
        Route::post('/students/{student}/classes/{schoolClass}', [StudentController::class, 'assignClass'])->name('students.assignClass');

        // School Class Routes
        Route::apiResource('classes', SchoolClassController::class);
        // This creates: GET /api/v1/classes, POST /api/v1/classes, etc.

    });

});
