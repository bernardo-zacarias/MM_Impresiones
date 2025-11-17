<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Administracion\CategoriaController;
use App\Http\Controllers\Administracion\ProductoController;
use App\Http\Controllers\Administracion\PrecioCotizacionController; // Importamos el controlador de Cotizaciones
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CotizadorController;
use App\Http\Controllers\CatalogoController; 
use App\Http\Controllers\CarritoController; // ¡Importación crucial para el Carrito!
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PedidoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

// Password Reset Routes
Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');


// --- 2. Rutas Protegidas para el Administrador (Rol: admin)
Route::middleware(['auth', 'role:admin'])->prefix('administracion')->name('administracion.')->group(function () {
    
    // DASHBOARD
    Route::get('/', function () {
        $stats = [
            'categorias' => \App\Models\Categoria::count(),
            'productos' => \App\Models\Producto::count(),
            'pedidos_pendientes' => \App\Models\Pedido::whereIn('estado', ['pendiente', 'pagado', 'en_produccion'])->count(),
            'clientes' => \App\Models\User::where('rol', 'cliente')->count(),
        ];
        return view('administracion.dashboard', compact('stats')); 
    })->name('dashboard'); 

    // CRUD para Categorias
    Route::resource('categorias', CategoriaController::class);

    // CRUD para Productos
    Route::resource('productos', ProductoController::class);
    
    // GESTIÓN DE PEDIDOS
    Route::get('pedidos', [App\Http\Controllers\AdminPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('pedidos/{pedido}', [App\Http\Controllers\AdminPedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('pedidos/{pedido}/estado', [App\Http\Controllers\AdminPedidoController::class, 'updateEstado'])->name('pedidos.estado');
    Route::post('pedidos/{pedido}/notas', [App\Http\Controllers\AdminPedidoController::class, 'agregarNotas'])->name('pedidos.notas');
    Route::get('pedidos/{pedido}/archivos', [App\Http\Controllers\AdminPedidoController::class, 'descargarArchivos'])->name('pedidos.archivos');
    
    // GESTIÓN DE USUARIOS
    Route::resource('usuarios', App\Http\Controllers\Administracion\UserController::class);
    
    // RUTAS DE PRECIOS DE COTIZACIÓN
    
    // 1. Ruta para crear una Cotización asociada a un Producto
    Route::get('productos/{producto}/cotizaciones/create', [PrecioCotizacionController::class, 'createProductoCotizacion'])
         ->name('productos.cotizaciones.create');

    // 2. CRUD para Precios de Cotización
    Route::resource('cotizaciones', PrecioCotizacionController::class)->parameters([
        'cotizaciones' => 'cotizacion',
    ]);
});


// =======================================================
// --- 3. Ruta Protegida para Clientes (Home y Carrito)
// =======================================================
// Estas rutas requieren que el usuario haya iniciado sesión (middleware('auth'))
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home'); 
    })->name('home');
    
    // RUTAS DEL CARRITO
    // index: Muestra el contenido del carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    // store: Recibe el POST de los formularios de Catálogo y Cotizador
    Route::post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');
    // destroy: Para eliminar un ítem específico del carrito
    Route::delete('/carrito/{item}', [CarritoController::class, 'destroy'])->name('carrito.destroy'); 
    // RUTA DE CHECKOUT
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    // RUTAS DE PEDIDOS (HISTORIAL DE COMPRAS)
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    
    // RUTAS DE TRANSBANK (PAGOS)
    Route::get('/pagar/{pedido}', [App\Http\Controllers\TransbankController::class, 'iniciarPago'])->name('transbank.iniciar');
    
    // RUTAS DE PERFIL DE USUARIO (solo edición)
    Route::get('/perfil/editar', [App\Http\Controllers\ProfileController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [App\Http\Controllers\ProfileController::class, 'update'])->name('perfil.update');
});

// RUTA PÚBLICA DE CALLBACK TRANSBANK (sin autenticación requerida)
Route::post('/transbank/callback', [App\Http\Controllers\TransbankController::class, 'callback'])->name('transbank.callback');
Route::get('/transbank/callback', [App\Http\Controllers\TransbankController::class, 'callback'])->name('transbank.callback.get');


// =======================================================
// --- 4. Rutas Públicas (Catálogo y Cotizador)
// =======================================================
// Estas rutas son accesibles para todos (visitantes y usuarios registrados).

// Listado de Productos (Catálogo)
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');

// Vista de Producto Individual (Show)
Route::get('/catalogo/{producto}', [CatalogoController::class, 'show'])->name('catalogo.show');

// Cotizador
Route::get('/cotizador', [CotizadorController::class, 'index'])->name('cotizador.index');
Route::post('/cotizador', [CotizadorController::class, 'cotizar'])->name('cotizador.cotizar');


// Ruta por defecto
Route::get('/', function () {
    return view('welcome');
});