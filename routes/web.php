<?php

use App\Http\Controllers\Admin\HabitacionAdminController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\ReservaAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComprobanteController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

// ── Página de inicio ─────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── Autenticación ────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Habitaciones (público) ───────────────────────────────────
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');
Route::get('/habitaciones/{habitacion}', [HabitacionController::class, 'show'])->name('habitaciones.show');

// ── Rutas protegidas (cliente autenticado) ───────────────────
Route::middleware(['auth.cliente'])->group(function () {

    Route::get('/dashboard', function () {
        return view('cliente.dashboard');
    })->name('cliente.dashboard');

    // Reservas
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/crear', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/{reserva}', [ReservaController::class, 'show'])->name('reservas.show');
    Route::post('/reservas/{reserva}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');

    // Pagos
    Route::get('/pagos/{reserva}/iniciar', [PagoController::class, 'iniciar'])->name('pagos.iniciar');
    Route::get('/pagos/exitoso', [PagoController::class, 'exitoso'])->name('pagos.exitoso');
    Route::get('/pagos/fallido', [PagoController::class, 'fallido'])->name('pagos.fallido');

    // Comprobantes
    Route::get('/comprobantes/{comprobante}', [ComprobanteController::class, 'descargar'])->name('comprobantes.show');
});

// ── Webhook MercadoPago (sin auth) ───────────────────────────
Route::post('/webhook/mp', [PagoController::class, 'webhook'])->name('webhook.mp');

// ── Rutas Admin ──────────────────────────────────────────────
Route::middleware(['auth.admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Habitaciones
    Route::get('/habitaciones', [HabitacionAdminController::class, 'index'])->name('habitaciones.index');
    Route::post('/habitaciones/{habitacion}/estado', [HabitacionAdminController::class, 'cambiarEstado'])->name('habitaciones.estado');

    // Reservas
    Route::get('/reservas', [ReservaAdminController::class, 'index'])->name('reservas.index');
    Route::post('/reservas/{reserva}/checkin', [ReservaAdminController::class, 'checkIn'])->name('reservas.checkin');
    Route::post('/reservas/{reserva}/checkout', [ReservaAdminController::class, 'checkOut'])->name('reservas.checkout');
    Route::post('/reservas/{reserva}/cancelar', [ReservaAdminController::class, 'cancelar'])->name('reservas.cancelar');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteController::class, 'exportarPDF'])->name('reportes.pdf');
});

