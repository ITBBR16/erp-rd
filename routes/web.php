<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kios\KiosFileUpload;
use App\Http\Controllers\login\LoginController;
use App\Http\Controllers\wilayah\KotaController;
use App\Http\Controllers\kios\KiosShopController;
use App\Http\Controllers\kios\KiosPaymentController;
use App\Http\Controllers\kios\KiosProductController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\kios\KiosSupplierController;
use App\Http\Controllers\wilayah\KecamatanController;
use App\Http\Controllers\wilayah\KelurahanController;
use App\Http\Controllers\kios\DashboardKiosController;
use App\Http\Controllers\kios\KiosDailyRecapController;
use App\Http\Controllers\kios\KiosPengirimanController;
use App\Http\Controllers\kios\KiosShopSecondController;
use App\Http\Controllers\customer\AddCustomerController;
use App\Http\Controllers\customer\DataCustomerController;
use App\Http\Controllers\kios\AddKelengkapanKiosController;
use App\Http\Controllers\customer\DashboardCustomerController;
use App\Http\Controllers\kios\KiosKasirController;
use App\Http\Controllers\kios\KiosKomplainController;
use App\Http\Controllers\kios\KiosProductSecondController;
use App\Http\Controllers\logistik\LogistikDashboardController;
use App\Http\Controllers\logistik\LogistikPenerimaanController;
use App\Http\Controllers\logistik\LogistikValidasiProdukController;

Route::middleware('guest')->group(function (){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('form-login');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dependent Dropdown 
Route::get('/getKota/{provinsiId}', [KotaController::class, 'getKota']);
Route::get('/getKecamatan/{kotaId}', [KecamatanController::class, 'getKecamatan']);
Route::get('/getKelurahan/{kecamatanId}', [KelurahanController::class, 'getKelurahan']);

Route::middleware('superadmin')->group(function () {
    Route::get('/', function() {
        return view('admin.index');
    });
});

Route::middleware('kios')->group(function () {
    Route::prefix('/kios')->group(function () {
        Route::get('/', [DashboardKiosController::class, 'index']);
        Route::get('/daily-recap', [KiosDailyRecapController::class, 'index']);
        Route::post('/daily-recap', [KiosDailyRecapController::class, 'store'])->name('form-daily-recap');

        Route::resource('/supplier', KiosSupplierController::class);
        Route::resource('/shop', KiosShopController::class);
        Route::post('/shop', [KiosShopController::class, 'store'])->name('form-belanja');

        Route::resource('/shop-second', KiosShopSecondController::class)->names([
            'edit' => 'shop-second.quality-control',
        ]);
        Route::get('/get-kelengkapan-second/{jenisId}', [KiosShopSecondController::class, 'getKelengkapanSecond']);
        Route::get('/getCustomerbyNomor/{nomor}', [KiosShopSecondController::class, 'getCustomerbyNomor']);

        Route::resource('/product', KiosProductController::class);
        Route::resource('/product-second', KiosProductSecondController::class);
        Route::get('/get-paket-penjualan/{paketPenjualanId}', [KiosProductController::class, 'getPaketPenjualan']);

        Route::get('/add-product', [AddKelengkapanKiosController::class, 'index']);
        Route::post('/add-product', [AddKelengkapanKiosController::class, 'store'])->name('form-kelengkapan');
        Route::get('/getKelengkapan/{jenisId}', [AddKelengkapanKiosController::class, 'getKelengkapan']);

        Route::get('/upload', [KiosFileUpload::class, 'index']);
        Route::get('/getPaket', [KiosFileUpload::class, 'getPaket']);

        Route::resource('/pembayaran', KiosPaymentController::class);
        Route::post('/pembayaran/{id}', [KiosPaymentController::class, 'validasi'])->name('form-validasi-payment');

        Route::resource('/pengiriman', KiosPengirimanController::class)->only(['index', 'update']);
        Route::get('/getLayanan/{ekspedisiId}', [KiosPengirimanController::class, 'getLayanan']);

        Route::resource('/komplain', KiosKomplainController::class)->only(['index', 'update']);

        Route::resource('/kasir', KiosKasirController::class)->only(['index', 'store']);
        Route::get('/autocomplete', [KiosKasirController::class, 'autocomplete']);
        Route::get('/getSerialNumber/{id}', [KiosKasirController::class, 'getSerialNumber']);
        Route::get('/getCustomer/{customerId}', [KiosKasirController::class, 'getCustomer']);
    });
});

Route::middleware('logistik')->group(function () {
    Route::prefix('/logistik')->group(function () {
        Route::get('/', [LogistikDashboardController::class, 'index']);
        Route::resource('/penerimaan', LogistikPenerimaanController::class)->only(['index', 'update']);
        Route::resource('/validasi', LogistikValidasiProdukController::class)->only(['index', 'store']);
        Route::get('/getOrderList/{orderId}', [LogistikValidasiProdukController::class, 'getOrderList']);
        Route::get('/getQtyOrderList/{orderListId}', [LogistikValidasiProdukController::class, 'getQtyOrderList']);
    });
});

Route::middleware('access')->group(function () {
    Route::prefix('/customer')->group(function () {
        Route::get('/', [DashboardCustomerController::class, 'index']);
        
        Route::resource('/data-customer', DataCustomerController::class)->only(['index', 'update', 'destroy']);
        Route::get('/data-customer/search', [DataCustomerController::class, 'search']);
        
        Route::get('/add-customer', [AddCustomerController::class, 'index']);
        Route::post('/add-customer', [AddCustomerController::class, 'store'])->name('form-customer');
        
        Route::middleware('admin.superAdmin')->group(function () {
            Route::get('/add-user', [EmployeeController::class, 'index']);
            Route::post('/add-user', [EmployeeController::class, 'store'])->name('form-user');
        });
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

// Route::get('/content', function () {
//     return view('content.main.index');
// });


// Route::get('/repair', function () {
//     return view('repair.main.index');
// });


// Route::get('/logistik', function () {
//     return view('logistik.main.index');
// });
