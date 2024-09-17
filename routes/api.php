<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); 

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('client')->group(function () {
        Route::get("/", [ClientController::class, 'index']);
        Route::get("/{id}", [ClientController::class, 'show']);
        Route::post("/", [ClientController::class, 'store']);
        Route::put("/{id}", [ClientController::class, 'update']);
        Route::delete("/{id}", [ClientController::class, 'delete']);
    });
    
    Route::prefix('employee')->group(function () {
        Route::get("/", [EmployeeController::class, 'index']);
        Route::get("/{id}", [EmployeeController::class, 'show']);
        Route::post("/", [EmployeeController::class, 'store']);
        Route::put("/{id}", [EmployeeController::class, 'update']);
        Route::delete("/{id}", [EmployeeController::class, 'delete']);
    });
    
    Route::prefix('product')->group(function () {
        Route::get("/", [ProductController::class, 'index']);
        Route::get("/{id}", [ProductController::class, 'show']);
        Route::post("/", [ProductController::class, 'store']);
        Route::put("/{id}", [ProductController::class, 'update']);
        Route::delete("/{id}", [ProductController::class, 'delete']);
    });
    
    Route::post('/transactions', [TransactionController::class, 'store']); 
    Route::get('/transactions', [TransactionController::class, 'index']); 
    Route::get('/balance', [TransactionController::class, 'getBalance']);  
    
    Route::prefix('debts')->group(function () {
        Route::get('/', [DebtController::class, 'index']);
        Route::post('/', [DebtController::class, 'store']);
        Route::get('/{id}', [DebtController::class, 'show']);
        Route::put('/{id}', [DebtController::class, 'update']);
        Route::delete('/{id}', [DebtController::class, 'destroy']);
    });
});

