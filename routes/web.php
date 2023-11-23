<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InfoPedidoController;
use App\Http\Controllers\LineaPedidoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/categoria/{id}/{name}', [HomeController::class, 'showCategoria'])->name('show.categoria');


Route::get('/register',[RegisterController::class,'index'])->name('register');
Route::post('/register',[RegisterController::class,'store']);

Route::get('/categoria',[CategoriaController::class,'index'])->name('categoria');
Route::post('/categoria',[CategoriaController::class,'store']);

Route::get('/productos',[ItemController::class,'index'])->name('productos');
Route::post('/registerItem',[ItemController::class,'store']);
Route::post('/update', [ItemController::class, 'update'])->name('update.producto.item');

Route::get('/miCarrito', [LineaPedidoController::class, 'index'])->name('miCarrito');
Route::get('/CompraRealizada', [LineaPedidoController::class, 'compraRealizada']);
Route::get('/misPedidos', [LineaPedidoController::class, 'show'])->name('misPedidos');
Route::post('/register/pedido', [LineaPedidoController::class, 'store'])->name('register.pedido');

Route::get('/informacionPedido',[InfoPedidoController::class,'index'])->name('info.pedido');
Route::post('/register/InfoPedido',[InfoPedidoController::class,'store'])->name('register.InfoPedido');

Route::post('/registerProducto', [ProductoController::class,'store'])->name('register.productos');
Route::post('/buscarCodigos', [ProductoController::class, 'buscarCodigos']);

Route::post('/registerDatos', [DatoController::class, 'store'])->name('register.datos');
Route::get('/ultimaCompra', [DatoController::class, 'obtenerUltimoId']);


Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'store']);

Route::post('/logout',[LogoutController::class,'store'])->name('logout');

Route::get('/registros',[ComprasController::class,'index'])->name('admin.panel');
Route::get('/Cotizador',[ComprasController::class,'cotizar'])->name('cotizador');
Route::post('/registerCompra',[ComprasController::class,'store'])->name('register.compra');
Route::get('/detalles/{dato_id}',[ComprasController::class, 'detalles'])->name('detalles.compra');




Route::get('/Proveedores',[ProveedorController::class,'index'])->name('proveedores');
Route::post('/Proveedores',[ProveedorController::class,'store']);




