<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // import ProductController
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductController::class, 'index']); // Route syntax Route::method('path',[ControllerName::class, 'functionName'])

Route::post('/api/create', [ProductController::class, 'onCreate']);

Route::get('/api/getById/{id}', [ProductController::class, 'onEdit']);

Route::put('/api/update', [ProductController::class, 'onUpdate']);

Route::delete('/api/delete/{id}', [ProductController::class, 'onDelete']);

Route::get('/api/getAllData', [ProductController::class, 'getAllData']);