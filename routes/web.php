<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoDocController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS PARA CRUD DE DOCUMENTOS
    Route::get('documentsView', [DocumentoController::class, 'viewIndex'])->name('documentsView');
    Route::post('documentStore', [DocumentoController::class, 'storeDocument'])->name('documentStore');
    Route::put('documentUpdate/{id}', [DocumentoController::class, 'updateDocument'])->name('documentUpdate');
    Route::delete('documentDestroy/{id}', [DocumentoController::class, 'destroyDocument'])->name('documentDestroy');

    // RUTA PARA OBTENER VISTA PRINCIPAL DE CONFIG
    Route::get('configView', [ConfigController::class, 'viewIndex'])->name('configView');

    // RUTAS PARA PROCESOS
    Route::post('processStore', [ProcesoController::class, 'storeProcess'])->name('processStore');
    Route::put('processUpdate/{id}', [ProcesoController::class, 'updateProcess'])->name('processUpdate');
    Route::delete('processDestroy/{id}', [ProcesoController::class, 'destroyProcess'])->name('processDestroy');

    // RUTAS PARA TIPO
    Route::post('type_docStore', [TipoDocController::class, 'storeTypeDoc'])->name('type_docStore');
    Route::put('type_docUpdate/{id}', [TipoDocController::class, 'updateTypeDoc'])->name('type_docUpdate');
    Route::delete('type_docDestroy/{id}', [TipoDocController::class, 'destroyTypeDoc'])->name('type_docDestroy');
});

require __DIR__ . '/auth.php';
