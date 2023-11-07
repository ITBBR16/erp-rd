<?php

use App\Http\Controllers\customer\AddCustomerController;
use App\Http\Controllers\customer\DashboardCustomerController;
use App\Http\Controllers\customer\LogAdminController;
use App\Http\Controllers\wilayah\KecamatanController;
use App\Http\Controllers\wilayah\KelurahanController;
use App\Http\Controllers\wilayah\KotaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
});
Route::get('/gudang', function () {
    return view('gudang.main.index');
});
Route::get('gudang/sender', function () {
    return view('gudang.sender.main');
});
Route::get('gudang/belanja', function () {
    return view('gudang.shop.belanja.belanja');
});
Route::get('gudang/req-payment', function () {
    return view('gudang.shop.payment');
});
Route::get('gudang/input-resi', function () {
    return view('gudang.shop.resi');
});
Route::get('gudang/unboxing', function () {
    return view('gudang.checkpart.unboxing');
});
Route::get('gudang/quality-control', function () {
    return view('gudang.checkpart.qc.quality_control');
});
Route::get('gudang/quality-control/detail', function () {
    return view('gudang.checkpart.detail');
});
Route::get('gudang/validasi', function () {
    return view('gudang.checkpart.validasi');
});
Route::get('gudang/stock-opname', function () {
    return view('gudang.stockopname.stock_opname');
});
Route::get('gudang/inventory', function () {
    return view('gudang.main.inventory');
});
Route::get('gudang/inventory/tambah-sku', function () {
    return view('gudang.main.add_sku');
});


Route::get('/battery', function () {
    return view('battery.main.index');
});


Route::get('/kios', function () {
    return view('kios.main.index');
});


Route::get('/content', function () {
    return view('content.main.index');
});


Route::get('/repair', function () {
    return view('repair.main.index');
});


Route::get('/logistik', function () {
    return view('logistik.main.index');
});

Route::prefix('/customer')->group(function () {
    Route::resource('/', DashboardCustomerController::class)->only(['index', 'edit', 'update', 'destroy', 'search']);

    Route::get('/log-admin', [LogAdminController::class, 'index']);
    Route::get('/add-customer', [AddCustomerController::class, 'index']);
    Route::post('/add-customer', [AddCustomerController::class, 'store'])->name('form-customer');

});
// Dependent Dropdown 
Route::get('/getKota/{provinsiId}', [KotaController::class, 'getKota']);
Route::get('/getKecamatan/{kotaId}', [KecamatanController::class, 'getKecamatan']);
Route::get('/getKelurahan/{kecamatanId}', [KelurahanController::class, 'getKelurahan']);
