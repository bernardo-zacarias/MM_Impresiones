<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Administracion\CategoriaController;
use App\Http\Controllers\Administracion\ProductoController;
use App\Http\Controllers\Administracion\PrecioCotizacionController; // Importamos el controlador de Cotizaciones
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CotizadorController;
use App\Http\Controllers\CatalogoController; // Importar el nuevo controlador

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
    
    // 1. Ruta para crear una Cotización asociada a un Producto (productos/{producto}/cotizaciones/create)
    Route::get('productos/{producto}/cotizaciones/create', [PrecioCotizacionController::class, 'createProductoCotizacion'])
         ->name('productos.cotizaciones.create');

    // 2. CRUD para Precios de Cotización (Genérica: cotizaciones/...)
    // ¡CORRECCIÓN CLAVE! Usamos 'parameters' para forzar a Laravel a usar 'cotizacion' 
    // en la URL y en el controlador, resolviendo el problema de pluralización/singularización.
    Route::resource('cotizaciones', PrecioCotizacionController::class)->parameters([
        'cotizaciones' => 'cotizacion',
    ]);
});

// --- 3. Ruta Protegida para Clientes (Post-Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home'); 
    })->name('home');
});

// --- 4. Ruta Pública para el Cotizador

// Listado de Productos (Catálogo)
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');

// Vista de Producto Individual (Show)
Route::get('/catalogo/{producto}', [CatalogoController::class, 'show'])->name('catalogo.show');
// Cotizador
Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador.index');


// Ruta por defecto
Route::get('/', function () {
    return view('welcome');
});
