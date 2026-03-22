<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POS\PosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Admin\InformeController;

// Ruta raíz → redirige al POS
Route::get('/', fn() => redirect()->route('pos.index'));

// ── POS ──────────────────────────────────────────
Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
Route::post('/pos/venta', [PosController::class, 'registrarVenta'])->name('pos.venta');
Route::get('/pos/buscar-cliente', [PosController::class, 'buscarCliente'])->name('pos.buscarCliente');
Route::post('/pos/crear-cliente', [PosController::class, 'crearCliente'])->name('pos.crearCliente');

// ── ADMIN ─────────────────────────────────────────
Route::get('/admin', fn() => redirect()->route('admin.productos.index'));

// Productos
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('productos', ProductoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::get('informes', [InformeController::class, 'index'])->name('informes.index');
});
Route::patch('productos/{producto}/toggle', [ProductoController::class, 'toggle'])->name('admin.productos.toggle');