<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Administracion\CategoriaController;
use App\Http\Controllers\Administracion\ProductoController;
use App\Http\Controllers\Administracion\PrecioCotizacionController; // <-- Importamos el controlador de Cotizaciones
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí puedes registrar rutas web para tu aplicación.
|
*/

// --- 1. Rutas de Autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');


// --- 2. Rutas Protegidas para el Administrador (Rol: admin)
Route::middleware(['auth', 'role:admin'])->prefix('administracion')->name('administracion.')->group(function () {
    
    // DASHBOARD
    Route::get('/', function () {
        return view('administracion.dashboard'); 
    })->name('dashboard'); 

    // CRUD para Categorias
    Route::resource('categorias', CategoriaController::class);

    // CRUD para Productos
    Route::resource('productos', ProductoController::class);
    
    // RUTAS DE COTIZACIÓN
    
    // 1. Ruta para Listar Cotizaciones de un Producto Específico (NUEVA RUTA)
    Route::get('productos/{producto}/cotizaciones', [PrecioCotizacionController::class, 'indexProductoCotizacion'])
         ->name('productos.cotizaciones.index');

    // 2. Ruta para crear una Cotización asociada a un Producto (productos/{producto}/cotizaciones/create)
    Route::get('productos/{producto}/cotizaciones/create', [PrecioCotizacionController::class, 'createProductoCotizacion'])
         ->name('productos.cotizaciones.create');

    // 3. CRUD para Precios de Cotización (Genérica: cotizaciones/...)
    // Esta ruta debe ir al final para no interferir con las rutas específicas de 'productos'
    Route::resource('cotizaciones', PrecioCotizacionController::class);
});

// --- 3. Ruta Protegida para Clientes (Post-Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home'); 
    })->name('home');
});


// Ruta por defecto
Route::get('/', function () {
    return view('welcome');
});
