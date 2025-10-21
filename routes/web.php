<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Administracion\CategoriaController;
use App\Http\Controllers\Administracion\ProductoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController; // <-- IMPORTANTE: Añadimos el controlador de Login

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí puedes registrar rutas web para tu aplicación.
|
*/

// --- 1. Rutas de Autenticación
// (Laravel recomienda usar Auth::routes() o un scaffolding, pero usaremos las rutas manuales que hemos estado trabajando)

// Rutas de Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');

// Ruta de Registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

// Ruta de Logout (Esencial para la funcionalidad de las vistas)
Route::post('logout', function() {
    Auth::logout();
    return redirect('/');
})->name('logout');


// --- 2. Rutas Protegidas para el Administrador (Rol: admin)
Route::middleware(['auth', 'role:admin'])->prefix('administracion')->name('administracion.')->group(function () {
    
    // DASHBOARD ADMINISTRACIÓN: Ruta principal de /administracion
    Route::get('/', function () {
        // Carga la vista que tienes en resources/views/administracion/dashboard.blade.php
        return view('administracion.dashboard'); 
    })->name('dashboard'); 

    // CRUD para Categorias
    Route::resource('categorias', CategoriaController::class);

    // CRUD para Productos
    Route::resource('productos', ProductoController::class);
});


// --- 3. Ruta Protegida para Clientes (Post-Login)
Route::middleware(['auth'])->group(function () {
    // Esta es la ruta a donde redirige el Login exitoso (por defecto en Laravel)
    // Carga la vista resources/views/home.blade.php
    Route::get('/home', function () {
        return view('home'); 
    })->name('home');
});


// --- 4. Ruta por defecto (Página de Bienvenida)
Route::get('/', function () {
    return view('welcome');
});
