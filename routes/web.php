<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanPenjualanController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/login', [AuthenticationController::class, 'showFormLogin'])->name('login');
Route::post('/login', [AuthenticationController::class, 'postLogin'])->name('login.post');
Route::get('/register', [AuthenticationController::class, 'showFormRegister'])->name('register');
Route::post('/register', [AuthenticationController::class, 'postRegister'])->name('register.post');
Route::get('/logout', [AuthenticationController::class, 'Logout'])->name('logout');
//Route::get('/home', [HomeController::class, 'index'])->name('home');
// Routes untuk Admin & Kasir
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    // Pelanggan
    Route::get('/pelanggans', [PelangganController::class, 'index'])->name('pelanggans.index');
    Route::get('/pelanggans/create', [PelangganController::class, 'create'])->name('pelanggans.create');
    Route::post('/pelanggans', [PelangganController::class, 'store'])->name('pelanggans.store');
    Route::get('/pelanggans/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggans.edit');
    Route::put('/pelanggans/{id}', [PelangganController::class, 'update'])->name('pelanggans.update');
    Route::delete('/pelanggans/{id}', [PelangganController::class, 'destroy'])->name('pelanggans.destroy');

    // Penjualan
    Route::get('/penjualans', [PenjualanController::class, 'index'])->name('penjualans.index');
    Route::get('/penjualans/create', [PenjualanController::class, 'create'])->name('penjualans.create');
    Route::post('/penjualans', [PenjualanController::class, 'store'])->name('penjualans.store');
    Route::get('/penjualans/{id}/edit', [PenjualanController::class, 'edit'])->name('penjualans.edit');
    Route::put('/penjualans/{id}', [PenjualanController::class, 'update'])->name('penjualans.update');
    Route::delete('/penjualans/{id}', [PenjualanController::class, 'destroy'])->name('penjualans.destroy');
    Route::get('/penjualans/{id}', [PenjualanController::class, 'show'])->name('penjualans.show');

    // Produk (Kasir hanya bisa melihat index)
    Route::get('/produks', [ProdukController::class, 'index'])->name('produks.index');

    // Pembayaran
    Route::get('/pembayarans', [PembayaranController::class, 'index'])->name('pembayarans.index');
    Route::get('/pembayaran/create/{penjualanId}', [PembayaranController::class, 'create'])->name('pembayarans.create');
    Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/struk/{id}', [PembayaranController::class, 'showStruk'])->name('pembayaran.struk');
    Route::get('/pembayarans/{id}', [PembayaranController::class, 'show'])->name('pembayarans.show');
    
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanPenjualanController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/cetak', [LaporanPenjualanController::class, 'cetakLaporan'])->name('cetak');
        Route::get('/lihat', [LaporanPenjualanController::class, 'lihatLaporan'])->name('lihat');
    }); 
});

// Routes khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Produk
    Route::get('/produks/create', [ProdukController::class, 'create'])->name('produks.create');
    Route::post('/produks', [ProdukController::class, 'store'])->name('produks.store');
    Route::get('/produks/{id}', [ProdukController::class, 'show'])->name('produks.show');
    Route::get('/produks/{id}/edit', [ProdukController::class, 'edit'])->name('produks.edit');
    Route::put('/produks/{id}', [ProdukController::class, 'update'])->name('produks.update');
    Route::delete('/produks/{id}', [ProdukController::class, 'destroy'])->name('produks.destroy');

    // Kategori
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
    Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
    Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
    Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

    // Satuan (Unit)
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{id}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.destroy');

    // Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Stok Masuk
    Route::get('/stock_ins', [StockInController::class, 'index'])->name('stock_ins.index');
    Route::get('/stock_ins/create', [StockInController::class, 'create'])->name('stock_ins.create');
    Route::post('/stock_ins', [StockInController::class, 'store'])->name('stock_ins.store');
    Route::get('/stock_ins/{id}/edit', [StockInController::class, 'edit'])->name('stock_ins.edit');
    Route::put('/stock_ins/{id}', [StockInController::class, 'update'])->name('stock_ins.update');
    Route::delete('/stock_ins/{id}', [StockInController::class, 'destroy'])->name('stock_ins.destroy');

    // Stok Keluar
    Route::get('/stock_outs', [StockOutController::class, 'index'])->name('stock_outs.index');
    Route::get('/stock_outs/create', [StockOutController::class, 'create'])->name('stock_outs.create');
    Route::post('/stock_outs', [StockOutController::class, 'store'])->name('stock_outs.store');
    Route::get('/stock_outs/{id}/edit', [StockOutController::class, 'edit'])->name('stock_outs.edit');
    Route::put('/stock_outs/{id}', [StockOutController::class, 'update'])->name('stock_outs.update');
    Route::delete('/stock_outs/{id}', [StockOutController::class, 'destroy'])->name('stock_outs.destroy');
    
});

//Auth::routes();



