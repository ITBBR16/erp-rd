<?php

use App\Http\Controllers\customer\AddCustomerController;
use App\Http\Controllers\customer\DashboardCustomerController;
use App\Http\Controllers\customer\DataCustomerController;
use App\Http\Controllers\customer\LogAdminController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\login\LoginController;
use App\Http\Controllers\wilayah\KecamatanController;
use App\Http\Controllers\wilayah\KelurahanController;
use App\Http\Controllers\wilayah\KotaController;
use Illuminate\Support\Facades\Route;
use Psy\CodeCleaner\ReturnTypePass;

Route::middleware('guest')->group(function (){
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('form-login');
    });
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('/customer')->group(function () {
        Route::get('/', [DashboardCustomerController::class, 'index']);
        
        Route::resource('/data-customer', DataCustomerController::class)->only(['index', 'update', 'destroy'])->parameters(['' => 'customer']);
        Route::get('/data-customer/search', [DataCustomerController::class, 'search']);
        
        Route::get('/add-customer', [AddCustomerController::class, 'index']);
        Route::post('/add-customer', [AddCustomerController::class, 'store'])->name('form-customer');
        
        Route::middleware('admin.superadmin')->group(function () {
            Route::get('/add-user', [EmployeeController::class, 'index']);
            Route::post('/add-user', [EmployeeController::class, 'store'])->name('form-user');
        });
    });
});

// Dependent Dropdown 
Route::get('/getKota/{provinsiId}', [KotaController::class, 'getKota']);
Route::get('/getKecamatan/{kotaId}', [KecamatanController::class, 'getKecamatan']);
Route::get('/getKelurahan/{kecamatanId}', [KelurahanController::class, 'getKelurahan']);

Route::middleware('superadmin')->group(function () {
    Route::get('/', function() {
        return view('admin.index');
    });
});

// Route::get('/gudang', function () {
//     return view('gudang.main.index');
// });
// Route::get('gudang/sender', function () {
//     return view('gudang.sender.main');
// });
// Route::get('gudang/belanja', function () {
//     return view('gudang.shop.belanja.belanja');
// });
// Route::get('gudang/req-payment', function () {
//     return view('gudang.shop.payment');
// });
// Route::get('gudang/input-resi', function () {
//     return view('gudang.shop.resi');
// });
// Route::get('gudang/unboxing', function () {
//     return view('gudang.checkpart.unboxing');
// });
// Route::get('gudang/quality-control', function () {
//     return view('gudang.checkpart.qc.quality_control');
// });
// Route::get('gudang/quality-control/detail', function () {
//     return view('gudang.checkpart.detail');
// });
// Route::get('gudang/validasi', function () {
//     return view('gudang.checkpart.validasi');
// });
// Route::get('gudang/stock-opname', function () {
//     return view('gudang.stockopname.stock_opname');
// });
// Route::get('gudang/inventory', function () {
//     return view('gudang.main.inventory');
// });
// Route::get('gudang/inventory/tambah-sku', function () {
//     return view('gudang.main.add_sku');
// });


// Route::get('/battery', function () {
//     return view('battery.main.index');
// });


// Route::get('/kios', function () {
//     return view('kios.main.index');
// });


// Route::get('/content', function () {
//     return view('content.main.index');
// });


// Route::get('/repair', function () {
//     return view('repair.main.index');
// });


// Route::get('/logistik', function () {
//     return view('logistik.main.index');
// });
