<?php

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KiosDailyRecapExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login\LoginController;
use App\Http\Controllers\wilayah\KotaController;
use App\Http\Controllers\kios\KiosPODPController;
use App\Http\Controllers\kios\KiosShopController;
use App\Http\Controllers\kios\KiosDashboardProduk;
use App\Http\Controllers\kios\KiosKasirController;
use App\Http\Controllers\repair\RepairQCController;
use App\Http\Controllers\kios\KiosInputTSController;
use App\Http\Controllers\kios\KiosPaymentController;
use App\Http\Controllers\kios\KiosProductController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\kios\KiosKomplainController;
use App\Http\Controllers\kios\KiosSupplierController;
use App\Http\Controllers\wilayah\KecamatanController;
use App\Http\Controllers\wilayah\KelurahanController;
use App\Http\Controllers\gudang\GudangLabelController;
use App\Http\Controllers\kios\DashboardKiosController;
use App\Http\Controllers\repair\KasirRepairController;
use App\Http\Controllers\kios\KiosDailyRecapController;
use App\Http\Controllers\kios\KiosPengirimanController;
use App\Http\Controllers\kios\KiosShopSecondController;
use App\Http\Controllers\customer\AddCustomerController;
use App\Http\Controllers\gudang\GudangBelanjaController;
use App\Http\Controllers\customer\DataCustomerController;
use App\Http\Controllers\gudang\GudangSupplierController;
use App\Http\Controllers\gudang\GudangUnboxingController;
use App\Http\Controllers\repair\RepairListCaseController;
use App\Http\Controllers\repair\RepairNonKasirController;
use App\Http\Controllers\repair\ReviewCustomerController;
use App\Http\Controllers\gudang\GudangSplitPartController;
use App\Http\Controllers\kios\KiosProductSecondController;
use App\Http\Controllers\repair\RepairProdukSedangDikirim;
use App\Http\Controllers\repair\RepairTeknisiLCController;
use App\Http\Controllers\repair\RepairTeknisiNCController;
use App\Http\Controllers\gudang\GudangListProdukController;
use App\Http\Controllers\gudang\GudangValidasiQCController;
use App\Http\Controllers\kios\AddKelengkapanKiosController;
use App\Http\Controllers\repair\RepairPengerjaanController;
use App\Http\Controllers\gudang\GudangAdjustStockController;
use App\Http\Controllers\kios\KiosBuatPaketSecondController;
use App\Http\Controllers\kios\KiosPenerimaanProdukController;
use App\Http\Controllers\repair\RepairCustomerListController;
use App\Http\Controllers\repair\RepairKonfirmasiQCController;
use App\Http\Controllers\customer\DashboardCustomerController;
use App\Http\Controllers\kios\KiosAnalisaDailyRecapController;
use App\Http\Controllers\kios\KiosPengecekkanSecondController;
use App\Http\Controllers\logistik\LogistikDashboardController;
use App\Http\Controllers\repair\RepairEstimasiBiayaController;
use App\Http\Controllers\gudang\GudangQualityControlController;
use App\Http\Controllers\gudang\GudangRequestPaymentController;
use App\Http\Controllers\gudang\GudangReturSparepartController;
use App\Http\Controllers\kios\KiosFilterProdukSecondController;
use App\Http\Controllers\logistik\LogistikPenerimaanController;
use App\Http\Controllers\repair\RepairRecapTransaksiController;
use App\Http\Controllers\gudang\GudangAddNewSparepartController;
use App\Http\Controllers\repair\RepairTroubleshootingController;
use App\Http\Controllers\gudang\GudangKomplainSupplierController;
use App\Http\Controllers\repair\RepairRequestSparepartController;
use App\Http\Controllers\gudang\GudangPengirimanBelanjaController;
use App\Http\Controllers\kios\DashboardTechnicalSupportController;
use App\Http\Controllers\kios\KiosPengecekkanProdukBaruController;
use App\Http\Controllers\repair\RepairKonfirmasiReqPartController;
use App\Http\Controllers\logistik\LogistikValidasiProdukController;
use App\Http\Controllers\repair\RepairKonfirmasiEstimasiController;
use App\Http\Controllers\repair\RepairPenerimaanSparepartController;
use App\Http\Controllers\gudang\GudangKonfirmasiPengirimanController;
use App\Http\Controllers\logistik\LogistikListCaseRepairController;
use App\Http\Controllers\logistik\LogistikSentToRepairController;
use App\Http\Controllers\repair\RepairEstimasiReqSparepartController;
use App\Http\Controllers\repair\RepairPenerimaanPartEstimasiController;
use App\Http\Controllers\repair\RepairTeknisiRequestSparepartController;

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('form-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dependent Dropdown 
Route::get('/getKota/{provinsiId}', [KotaController::class, 'getKota']);
Route::get('/getKecamatan/{kotaId}', [KecamatanController::class, 'getKecamatan']);
Route::get('/getKelurahan/{kecamatanId}', [KelurahanController::class, 'getKelurahan']);

Route::get('/review-customer/{increment}', [ReviewCustomerController::class, 'index']);
Route::post('/review-customer', [ReviewCustomerController::class, 'store'])->name('createReviewCustomer');

Route::middleware('superadmin')->group(function () {
    Route::get('/', function() {
        return view('admin.index');
    });
});

Route::middleware('kios')->group(function () {
    Route::prefix('/kios')->group(function () {

        Route::get('/test-export', function () {
            $export = new KiosDailyRecapExport();
            return response()->json($export->collection());
        });
        Route::get('/download-recap', function () {
            $timestamp = Carbon::now()->format('d M Y');
            $fileName = "Kios Daily Recap - {$timestamp}.csv";
            return Excel::download(new KiosDailyRecapExport, $fileName);
        })->name('download.recap');

        Route::prefix('/analisa')->group(function () {
            Route::get('/dashboard', [DashboardKiosController::class, 'index']);
            Route::get('/analisa-daily-recap', [KiosAnalisaDailyRecapController::class, 'index'])->name('analisa-dr');
            Route::get('/analisa-chart', [DashboardKiosController::class, 'analisaChart']);
        });

        Route::prefix('/customer')->group(function () {
            Route::resource('/daily-recap', KiosDailyRecapController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::group(['controller' => KiosDailyRecapController::class], function () {
                Route::post('/new-customer', 'newCustomer')->name('newCustomer');
                Route::get('/getJenisProduk/{kondisiProduk}', 'getProduk');
                Route::get('/getSubJenisProduk/{kondisiProduk}/{id}', 'getSubjenis');
                Route::get('/getListProduk/{kondisiProduk}/{id}', 'getListProduk');
                Route::get('/getPaketPenjualan/{id}', 'getPaketPenjualan');
                Route::get('/getPermasalahan/{jenisId}/{kategoriId}', 'getPermasalahan');
                Route::get('/getDeskripsiPermasalahan/{id}', 'getDeskripsiPermasalahan');
            });
            Route::group(['controller' => DataCustomerController::class], function () {
                Route::resource('/list-customer', DataCustomerController::class)->only('index', 'update', 'delete');
                Route::get('/getDataCustomer/{id}', 'getDataCustomer');
                Route::get('/list-customer/search', [DataCustomerController::class, 'search']);
            });
        });

        Route::prefix('/product')->group(function () {
            Route::group(['controller' => KiosDashboardProduk::class], function () {
                Route::get('/dashboard-produk', 'index');
                Route::get('/weekly-sales-data', 'getWeeklySalesData');
            });

            Route::group(['controller' => KiosProductController::class], function () {
                Route::resource('/list-product', KiosProductController::class)->only(['index', 'update', 'destroy']);
                Route::post('/update-srp-baru', 'updateSrpBaru');
                Route::put('/update-produk-baru', 'updateProdukBaru')->name('updateProdukBaru');
                Route::get('/get-paket-penjualan/{paketPenjualanId}', 'getPaketPenjualan');
                Route::get('/getKelengkapans/{id}', 'getKelengkapans');
            });

            Route::group(['controller' => KiosProductSecondController::class], function () {
                Route::resource('/list-product-second', KiosProductSecondController::class);
                Route::post('/update-srp-second', 'updateSRPSecond');
            });

            Route::resource('/shop', KiosShopController::class);

            Route::group(['controller' => KiosShopSecondController::class], function () {
                Route::resource('/shop-second', KiosShopSecondController::class);
                Route::post('/validasiSecond/{id}', 'validasisecond')->name('validasi-payment-second');
                Route::get('/getCustomerbyNomor/{nomor}', 'getCustomerbyNomor');
                Route::get('/getKelengkapanSecond/{id}', 'getKelengkapanSecond');
            });

            Route::group(['controller' => KiosPaymentController::class], function () {
                Route::resource('/pembayaran', KiosPaymentController::class)->only(['index', 'update']);
                Route::post('/pembayaran/{id}', 'validasi')->name('form-validasi-payment');
            });

            Route::group(['controller' => KiosPengirimanController::class], function () {
                Route::resource('/pengiriman', KiosPengirimanController::class)->only(['index', 'update']);
                Route::get('/getLayanan/{ekspedisiId}', 'getLayanan');
            });

            Route::group(['controller' => AddKelengkapanKiosController::class], function () {
                Route::get('/add-product', 'index');
                Route::post('/add-product', 'store')->name('form-kelengkapan');
                Route::get('/getKelengkapan/{jenisId}', 'getKelengkapan');
            });

            Route::group(['controller' => KiosBuatPaketSecondController::class], function () {
                Route::resource('add-paket-penjualan-second', KiosBuatPaketSecondController::class)->only(['index', 'store']);
                Route::get('/getKelengkapanSecond', 'getKelengkapanSecond');
                Route::get('/getSNSecond/{id}', 'getSNSecond');
                Route::get('/getPriceSecond/{id}', 'getPriceSecond');
            });

            Route::resource('/penerimaan-produk', KiosPenerimaanProdukController::class)->only(['index', 'update']);
            
            Route::group(['controller' => KiosPengecekkanProdukBaruController::class], function () {
                Route::resource('/qc-produk-baru', KiosPengecekkanProdukBaruController::class)->only(['index', 'store']);
                Route::get('/getOrderList/{orderId}', 'getOrderList');
                Route::get('/getQtyOrderList/{orderListId}', 'getQtyOrderList');
            });

            Route::resource('/pengecekkan-produk-second', KiosPengecekkanSecondController::class)->names([
                'edit' => 'pengecekkan-produk-second.quality-control',
            ]);

            Route::resource('/filter-product-second', KiosFilterProdukSecondController::class);

            Route::group(['controller' => KiosSupplierController::class], function () {
                Route::resource('/supplier-kios', KiosSupplierController::class);
                Route::put('/supplier/update-support', 'supportSupplier')->name('support-supplier');
            });

            Route::resource('/komplain', KiosKomplainController::class)->only(['index', 'update']);
        });

        Route::prefix('/kasir')->group(function () {
            Route::group(['controller' => KiosKasirController::class], function () {
                Route::resource('/kasir', KiosKasirController::class)->only(['index', 'store', 'edit', 'update']);
                Route::get('/autocomplete/{jenisTransaksi}', 'autocomplete');
                Route::get('/getSerialNumber/{jenisTransaksi}/{id}', 'getSerialNumber');
                Route::get('/getCustomer/{customerId}', 'getCustomer');
                Route::post('/generate-pdf', 'downloadInvoice');
            });
            Route::group(['controller' => KiosPODPController::class], function () {
                Route::resource('/dp-po', KiosPODPController::class);
                Route::get('/getSrpProduk/{jenisTransaksi}/{id}', 'getSrpProduk');
            });
        });

        Route::prefix('/technical-support')->group(function () {
            Route::get('/dashboard', [DashboardTechnicalSupportController::class, 'index']);
            Route::resource('/input', KiosInputTSController::class);
        });

    });
});

Route::middleware('logistik')->group(function () {
    Route::prefix('/logistik')->group(function () {
        Route::get('/', [LogistikDashboardController::class, 'index']);
        Route::resource('/penerimaan-logistik', LogistikPenerimaanController::class)->only(['index', 'update']);
        Route::group(['controller' => LogistikSentToRepairController::class], function () {
            Route::resource('/sent-to-rapair', LogistikSentToRepairController::class)->only(['index', 'update', 'edit']);
            Route::get('/logistik-get-kelengkapan/{id}', 'getKelengkapan');
        });
        Route::group(['controller' => LogistikListCaseRepairController::class], function () {
            Route::get('/list-case-repair', 'index')->name('logistiklcr');
            Route::get('/list-case-repair/{id}', 'pageDetailListCaseLogistik')->name('pageDetailListCaseLogistik');
        });
        // Route lama
        Route::resource('/validasi', LogistikValidasiProdukController::class)->only(['index', 'store']);
        Route::get('/getOrderList/{orderId}', [LogistikValidasiProdukController::class, 'getOrderList']);
        Route::get('/getQtyOrderList/{orderListId}', [LogistikValidasiProdukController::class, 'getQtyOrderList']);
        Route::get('/testFormId/{orderListId}', [LogistikValidasiProdukController::class, 'testFormId']);
    });
});

Route::middleware('access')->group(function () {
    Route::prefix('/customer')->group(function () {
        Route::get('/', [DashboardCustomerController::class, 'index']);
        
        Route::resource('/data-customer', DataCustomerController::class)->only(['index', 'update', 'destroy']);
        Route::get('/data-customer/search', [DataCustomerController::class, 'search']);
        
        Route::get('/add-customer', [AddCustomerController::class, 'index']);
        Route::post('/add-customer', [AddCustomerController::class, 'store'])->name('form-customer');
        
        Route::middleware('superadmin')->group(function () {
            Route::get('/add-user', [EmployeeController::class, 'index']);
            Route::post('/add-user', [EmployeeController::class, 'store'])->name('form-user');
        });
    });
});

Route::middleware('repair')->group(function () {
    Route::prefix('/repair')->group(function () {
        Route::prefix('/analisa')->group(function () {
            // Rute analisis
        });

        Route::prefix('/customer')->group(function () {

            Route::get('/produk-dikirim', [RepairProdukSedangDikirim::class, 'index'])->name('index-produk-dikirim');

            Route::resource('/list-customer-repair', RepairCustomerListController::class)->only(['index', 'store', 'update', 'destroy']);
            Route::get('/list-customer-repair/search', [RepairCustomerListController::class, 'search']);
        });

        Route::prefix('/csr')->group(function () {
            Route::group(['controller' => RepairListCaseController::class], function () {
                Route::resource('/case-list', RepairListCaseController::class)->only(['index', 'edit', 'update', 'store']);
                Route::get('/detail-list-case/{id}', 'detailListCase')->name('detailListCase');
                Route::post('/create-nc', 'createNC')->name('createNC');
                Route::get('/getKelengkapan/{id}', 'getKelengkapan');
                Route::get('/reviewPdfTandaTerima/{id}', 'reviewPdfTandaTerima');
                Route::get('/reviewPdfInvoiceLunas/{id}', 'reviewPdfInvoiceLunas');
                Route::get('/downloadPdf/{id}', 'downloadPdf')->name('downloadPdf');
                Route::post('/kirimTandaTerima/{id}', 'kirimTandaTerimaCustomer')->name('kirimTandaTerima');
            });

            Route::group(['controller' => KasirRepairController::class], function () {
                Route::resource('/kasir-repair', KasirRepairController::class)->only(['index', 'edit']);
                Route::get('/detail-kasir/{id}', 'detailKasir')->name('detailKasir');
                Route::post('/add-ongkir-repair/{id}', 'createOngkirKasir')->name('createOngkirKasir');
                Route::get('/kasir-repair-dp/{encryptId}', 'downpaymentKasir')->name('downpaymentKasir');
                Route::get('/getDataCustomer/{id}', 'getDataCustomer');
                Route::get('/getLayanan/{id}', 'getLayanan');
                Route::get('/preview-pelunasan/{id}', 'previewPdfPelunasan');
                Route::get('/preview-down-payment/{id}', 'previewPdfDp');
                Route::post('/create-pelunasan/{id}', 'createPelunasan')->name('createPelunasan');
                Route::post('/create-pembayaran/{id}', 'createPembayaran')->name('createPembayaran');
                Route::post('/konfirmasi-alamat-csr/{id}', 'konfirmasiAlamat')->name('konfirmasiAlamatCSR');
            });

            Route::resource('/non-kasir', RepairNonKasirController::class)->only(['index']);

            Route::group(['controller' => RepairRecapTransaksiController::class], function () {
                Route::resource('/recap-transaksi', RepairRecapTransaksiController::class)->only(['index', 'store']);
                Route::get('/getSaldoAkhirMutasi/{akunId}', 'getSaldoAkhirMutasi');
                Route::get('/findMutasiSementara/{id}', 'findMutasiSementara');
                Route::get('/findTransaksi/{source}/{id}', 'findTransaksi');
                Route::post('/merge-mutasi-transaksi', 'pencocokanMutasiTransaksi')->name('mergeMutasiTransaksi');
            });

            Route::group(['controller' => RepairKonfirmasiQCController::class], function () {
                Route::resource('/konfirmasi-qc', RepairKonfirmasiQCController::class)->only(['index', 'update']);
                Route::get('/detail-konfirmasi-qc/{id}', 'detailKonfirmasiQC')->name('detailKonfirmasiQC');
                Route::post('/sendKonfQc/{id}', 'sendKonfirmasiQC')->name('sendKonfirmasiQC');
                Route::get('/preview-qc/{id}', 'previewPdfQc');
            });

            Route::resource('/request-sparepart', RepairRequestSparepartController::class)->only(['index', 'update']);

            Route::resource('/penerimaan-sparepart', RepairPenerimaanSparepartController::class)->only(['index']);
        });

        Route::prefix('/teknisi')->group(function () {
            Route::get('/list-cases', [RepairTeknisiLCController::class, 'index'])->name('listCaseTeknisi');
            Route::get('/detail-cases-teknisi/{id}', [RepairTeknisiLCController::class, 'pageDetailCaseTeknisi'])->name('pageDetailCaseTeknisi');
            Route::resource('/new-case-teknisi', RepairTeknisiNCController::class)->only(['index', 'update']);
            Route::resource('/troubleshooting', RepairTroubleshootingController::class)->only(['index', 'update']);
            Route::put('/change-to-estimasi/{id}', [RepairTroubleshootingController::class, 'changeStatus'])->name('change-to-estimasi');

            Route::resource('/pengerjaan', RepairPengerjaanController::class)->only(['index', 'update']);
            Route::get('/detail-pengerjaan-teknisi/{id}',[RepairPengerjaanController::class, 'detailPengerjaan'])->name('detailPengerjaan');
            Route::put('/changeStatusPengerjaan/{id}', [RepairPengerjaanController::class, 'changeStatusPengerjaan'])->name('changeStatusPengerjaan');

            Route::resource('/req-sparepart-teknisi', RepairTeknisiRequestSparepartController::class)->only(['index', 'update']);
        });

        Route::prefix('/estimasi')->group(function () {
            Route::group(['controller' => RepairEstimasiBiayaController::class], function () {
                Route::resource('/estimasi-biaya', RepairEstimasiBiayaController::class)->only(['index', 'update', 'edit']);
                Route::get('/detail-estimasi/{id}', 'detailEstimasi')->name('detailEstimasi');
                Route::post('/addJurnalEstimasi', 'inputJurnalEstimasi')->name('addJurnalEstimasi');
                Route::get('/jenisDrone', 'getJenisDrone');
                Route::get('/getPartGudang/{jenisDrone}', 'getPartGudang');
                Route::get('/getDetailGudang/{id}', 'getDetailGudang');
            });

            Route::resource('/req-sparepart-estimasi', RepairEstimasiReqSparepartController::class)->only(['index', 'update']);
            Route::resource('/penerimaan-sparepart-estimasi', RepairPenerimaanPartEstimasiController::class)->only(['index', 'store', 'update']);

            Route::group(['controller' => RepairKonfirmasiEstimasiController::class], function () {
                Route::resource('/konfirmasi-estimasi', RepairKonfirmasiEstimasiController::class)->only(['index', 'edit', 'update']);
                Route::get('/detail-konfirmasi/{id}', 'detailKonfirmasi')->name('detailKonfirmasi');
                Route::post('/kirimPesanEstimasi', 'kirimPesanEstimasi')->name('kirimPesanEstimasi');
                Route::put('/konfirmasiEstimasi/{id}', 'konfirmasiEstimasi')->name('konfirmasiEstimasi');
                Route::post('/addJurnalKonfirmasi', 'addJurnalKonfirmasi')->name('addJurnalKonfirmasi');
                Route::put('/konfirmasiPengerjaan/{id}', 'konfirmasiPengerjaan')->name('konfirmasiPengerjaan');
            });

            Route::group(['controller' => RepairKonfirmasiReqPartController::class], function () {
                Route::resource('/konfirmasi-req-sparepart', RepairKonfirmasiReqPartController::class)->only(['index', 'store']);
                Route::get('/getDataRequestPart/{id}', 'getListPart');
            });
            
        });

        Route::prefix('/quality-control')->group(function () {
            Route::group(['controller' => RepairQCController::class], function () {
                Route::resource('/pengecekkan', RepairQCController::class)->only(['index', 'update']);
                Route::post('/createJurnalQc', 'createJurnalQc')->name('createJurnalQc');
                Route::post('/createQcFisik', 'createQcFisik')->name('createQcFisik');
                Route::post('/createQcCalibrasi', 'createQcCalibrasi')->name('createQcCalibrasi');
                Route::post('/createTestFly', 'createTestFly')->name('createTestFly');
                Route::get('/detail-qc/{id}', 'detailQualityControl')->name('detailQc');
                Route::get('/list-case-qc', 'indexListCase')->name('listCaseQC');
            });
        });

    });
});

Route::middleware('gudang')->group(function () {
    Route::prefix('/gudang')->group(function () {
        Route::prefix('/purchasing')->group(function () {
            Route::group(['controller' => GudangBelanjaController::class], function () {
                Route::resource('/belanja-sparepart', GudangBelanjaController::class)->only(['index', 'store', 'edit', 'update']);
                Route::get('/sparepart-bjenis/{id}', 'getSparepartByJenis');
                Route::post('/belanja-req-payment/{id}', 'requestPaymentBelanja')->name('requestPB');
            });
            Route::resource('/request-payment', GudangRequestPaymentController::class)->only(['index', 'store']);
            Route::resource('/pengiriman-belanja', GudangPengirimanBelanjaController::class)->only(['index', 'store', 'update']);
            Route::resource('/supplier', GudangSupplierController::class)->only(['index', 'store', 'update']);
        });

        Route::prefix('/receive')->group(function () {
            Route::resource('/unboxing-gd', GudangUnboxingController::class)->only(['index', 'update']);
            Route::group(['controller' => GudangQualityControlController::class], function () {
                Route::resource('/gudang-qc', GudangQualityControlController::class)->only(['index', 'store']);
                Route::get('cek-fisik/{idBelanja}/{idProduk}', 'cekQcFisik')->name('qcFisik');
                Route::get('cek-fungsional/{idBelanja}/{idProduk}', 'cekQcFungsional')->name('qcFungsional');
                Route::post('cek-fungsional', 'storeFungsional')->name('storeFungsional');
            });
            Route::group(['controller' => GudangValidasiQCController::class], function () {
                Route::resource('/gudang-validasi', GudangValidasiQCController::class)->only(['index', 'store']);
                Route::get('/cek-validasi/{idBelanja}/{idProduk}', 'pageValidasi')->name('pageValidasi');
            });
            Route::group(['controller' => GudangLabelController::class], function () {
                Route::get('/list-label', 'index')->name('list-label');
                Route::get('/print-label/{idBelanja}/{idProduk}', 'printLabel')->name('printLabel');
                Route::resource('/komplain-supplier', GudangKomplainSupplierController::class)->only(['index']);
            });
        });

        Route::prefix('/produk')->group(function () {
            Route::group(['controller' => GudangListProdukController::class], function () {
                Route::resource('/list-produk', GudangListProdukController::class)->only(['index', 'update']);
                Route::post('/update-harga-sparepart/{id}', 'updateHarga');
            });
            Route::group(['controller' => GudangSplitPartController::class], function () {
                Route::resource('/split-sku', GudangSplitPartController::class)->only(['index', 'store']);
                Route::get('/get-list-id-item/{id}', 'getListIdItem');
                Route::get('/get-db-id-item/{id}', 'detailBelanjaIdItem');
            });
            Route::resource('/adjust-stock', GudangAdjustStockController::class)->only(['index', 'store']);
            Route::resource('/add-sparepart', GudangAddNewSparepartController::class)->only(['index', 'store']);
        });

        Route::prefix('/distribusi')->group(function () {
            Route::resource('/konfirmasi-pengiriman', GudangKonfirmasiPengirimanController::class)->only(['index', 'edit', 'store']);
            Route::resource('/retur-sparepart', GudangReturSparepartController::class)->only(['index']);
        });
    });
});
