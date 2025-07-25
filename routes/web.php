<?php

use Carbon\Carbon;
use App\Exports\AkademiExport;
use App\Exports\EkspedisiExport;
use App\Exports\KiosSalesExport;
use App\Models\wilayah\Provinsi;
use App\Exports\GudangRequestData;
use App\Exports\KiosFinanceExport;
use App\Exports\EstimasiPartExport;
use App\Exports\GudangIdItemExport;
use App\Exports\GudangProdukExport;
use App\Models\kios\KiosDailyRecap;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KiosDailyRecapExport;
use App\Exports\RepairEstimasiExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;
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
use App\Http\Controllers\kios\KiosProductBnobController;
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
use App\Http\Controllers\gudang\GudangKonfirmasiPembayaran;
use App\Http\Controllers\gudang\GudangListProdukController;
use App\Http\Controllers\gudang\GudangValidasiQCController;
use App\Http\Controllers\kios\AddKelengkapanKiosController;
use App\Http\Controllers\kios\KiosRequestPackingController;
use App\Http\Controllers\kios\KiosSplitDroneBaruController;
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
use App\Http\Controllers\logistik\LogistikResiPickupController;
use App\Http\Controllers\repair\RepairRecapTransaksiController;
use App\Http\Controllers\repair\RepairRequestPackingController;
use App\Http\Controllers\gudang\GudangAddNewSparepartController;
use App\Http\Controllers\repair\RepairTroubleshootingController;
use App\Http\Controllers\gudang\GudangKomplainSupplierController;
use App\Http\Controllers\logistik\LogistikSentToRepairController;
use App\Http\Controllers\repair\RepairRequestSparepartController;
use App\Http\Controllers\gudang\GudangPengirimanBelanjaController;
use App\Http\Controllers\kios\DashboardTechnicalSupportController;
use App\Http\Controllers\kios\KiosPengecekkanProdukBaruController;
use App\Http\Controllers\repair\RepairDashboardEstimasiController;
use App\Http\Controllers\repair\RepairKonfirmasiReqPartController;
use App\Http\Controllers\logistik\LogistikListCaseRepairController;
use App\Http\Controllers\logistik\LogistikRequestPackingController;
use App\Http\Controllers\logistik\LogistikRequestPaymentController;
use App\Http\Controllers\repair\RepairKonfirmasiEstimasiController;
use App\Http\Controllers\repair\RepairPenerimaanSparepartController;
use App\Http\Controllers\gudang\GudangKonfirmasiPengirimanController;
use App\Http\Controllers\repair\RepairEstimasiReqSparepartController;
use App\Http\Controllers\repair\RepairRubahEstimasiGeneralController;
use App\Http\Controllers\gudang\GudangDashboardDistributionController;
use App\Http\Controllers\logistik\LogistikListRequestPackingController;
use App\Http\Controllers\repair\RepairPenerimaanPartEstimasiController;
use App\Http\Controllers\repair\RepairTeknisiRequestSparepartController;

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('form-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dependent Dropdown 
Route::get('/getProvinsi', function () {
    $provinsi = Provinsi::all();
    return response()->json($provinsi);
});
Route::get('/getKota/{provinsiId}', [KotaController::class, 'getKota']);
Route::get('/getKecamatan/{kotaId}', [KecamatanController::class, 'getKecamatan']);
Route::get('/getKelurahan/{kecamatanId}', [KelurahanController::class, 'getKelurahan']);

Route::get('/review-customer/{increment}', [ReviewCustomerController::class, 'index']);
Route::post('/review-customer', [ReviewCustomerController::class, 'store'])->name('createReviewCustomer');

Route::get('/preview-sertificate', [CertificateController::class, 'previewSertificate']);

// Route::get('/preview-export', function () {
//     $export = new KiosDailyRecapExport();
//     return response()->json($export->collection());
// });

// Route::get('/download-export-produk', function () {
//     $timestamp = Carbon::now()->format('d M Y');
//     $fileName = "Data Daily Recap {$timestamp}.csv";
//     return Excel::download(new KiosDailyRecapExport, $fileName);
// });

Route::middleware('superadmin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });
});

Route::middleware('kios')->group(function () {
    Route::prefix('/kios')->group(function () {

        // Route::get('/test-export', function () {
        //     $export = new KiosDailyRecapExport();
        //     return response()->json($export->collection());
        // });

        // Route::get('/download-recap', function () {
        //     $timestamp = Carbon::now()->format('d M Y');
        //     $fileName = "Data Daily Recap - {$timestamp}.csv";
        //     return Excel::download(new KiosDailyRecapExport, $fileName);
        // })->name('download.recap');

        Route::prefix('/analisa')->group(function () {
            Route::get('/dashboard', [DashboardKiosController::class, 'index']);
            Route::get('/analisa-daily-recap', [KiosAnalisaDailyRecapController::class, 'index'])->name('analisa-dr');
            Route::get('/export-daily-recap', [KiosAnalisaDailyRecapController::class, 'exportDailyRecap'])->name('export-daily-recap');
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
                Route::resource('/list-product', KiosProductController::class)->only(['index', 'edit', 'update', 'destroy']);
                Route::post('/update-srp-baru', 'updateSrpBaru');
                Route::put('/update-produk-baru', 'updateProdukBaru')->name('updateProdukBaru');
                Route::get('/get-paket-penjualan/{paketPenjualanId}', 'getPaketPenjualan');
                Route::get('/getKelengkapans/{id}', 'getKelengkapans');
            });

            Route::group(['controller' => KiosProductSecondController::class], function () {
                Route::resource('/list-product-second', KiosProductSecondController::class)->only(['index', 'edit', 'update']);
                Route::post('/update-srp-second', 'updateSRPSecond');
            });

            Route::group(['controller' => KiosProductBnobController::class], function () {
                Route::resource('/list-product-bnob', KiosProductBnobController::class)->only(['index']);
                Route::post('/update-srp-bnob', 'updateSRPBnob');
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

            Route::resource('/penerimaan-produk', KiosPenerimaanProdukController::class)->only(['index', 'update']);

            Route::group(['controller' => KiosBuatPaketSecondController::class], function () {
                Route::resource('add-paket-penjualan-second', KiosBuatPaketSecondController::class)->only(['index', 'store']);
                Route::get('/getKelengkapanSecond', 'getKelengkapanSecond');
                Route::get('/getSNSecond/{id}', 'getSNSecond');
                Route::get('/getPriceSecond/{id}', 'getPriceSecond');
            });

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

            Route::group(['controller' => AddKelengkapanKiosController::class], function () {
                Route::get('/add-product', 'index');
                Route::post('/add-product', 'store')->name('form-kelengkapan');
                Route::get('/getKelengkapan/{jenisId}', 'getKelengkapan');
            });

            Route::group(['controller' => KiosSplitDroneBaruController::class], function () {
                Route::resource('/split-produk-baru', KiosSplitDroneBaruController::class)->only(['index', 'store', 'edit', 'update']);
                Route::post('/create-paket-bnob', 'createPaketPenjualanBnob')->name('createbnob');
                Route::get('/get-sn-split/{id}', 'getSnSplit');
                Route::get('/get-kelengkapan-split/{id}/{idSn}', 'getKelengkapanSplitBaru');
                Route::get('/get-kelengkapan-bnob', 'getKelengkapanSplitBnob');
                Route::get('/get-sn-bnob/{id}', 'getSerialNumberSplitBnob');
                Route::get('/get-modal-bnob/{id}', 'getNominalKelengkapanSplit');
            });

            Route::resource('/komplain', KiosKomplainController::class)->only(['index', 'update']);
        });

        Route::prefix('/kasir')->group(function () {
            Route::group(['controller' => KiosKasirController::class], function () {
                Route::resource('/kasir', KiosKasirController::class)->only(['index', 'store', 'edit', 'update']);
                Route::get('history-transaksi', 'indexHistory')->name('indexHistory');
                Route::get('/autocomplete/{jenisTransaksi}', 'autocomplete');
                Route::get('/getSerialNumber/{jenisTransaksi}/{id}', 'getSerialNumber');
                Route::get('/getNilaiDroneSecond/{id}', 'getNilaiDroneSecond');
                Route::get('/get-nilai-bnob/{id}', 'getNilaiBnob');
                Route::get('/getCustomer/{customerId}', 'getCustomer');
                Route::get('/generate-pdf', 'previewPdfKasir');
                Route::post('/updateDataCustomer', 'updateDataCustomer');
            });

            Route::group(['controller' => KiosPODPController::class], function () {
                Route::resource('/dp-po', KiosPODPController::class);
                Route::get('/getSrpProduk/{jenisTransaksi}/{id}', 'getSrpProduk');
            });

            Route::resource('/req-packing-kios', KiosRequestPackingController::class)->only(['index', 'store']);
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

        Route::group(['controller' => LogistikListRequestPackingController::class], function () {
            Route::resource('/list-request-packing', LogistikListRequestPackingController::class)->only(['index', 'store']);
            // Route::get('/detail-request-packing/{id}', 'detailListCase')->name('detailListCase');
            Route::get('/review-label-pengiriman/{id}', 'reviewPdf')->name('reviewPdf');
        });

        Route::group(['controller' => LogistikRequestPackingController::class], function () {
            Route::resource('/form-req-packing', LogistikRequestPackingController::class)->only(['index', 'store']);
            Route::get('/get-customer-packing/{id}', 'getCustomer');
            Route::get('/get-layanan-ekspedisi/{id}', 'getLayanan');
        });

        Route::group(['controller' => LogistikResiPickupController::class], function () {
            Route::resource('/list-unpicked', LogistikResiPickupController::class)->only(['index', 'store']);
            Route::get('/get-data-req-packing/{jenis}/{id}', 'getDataByEkspedisi');
        });

        Route::resource('/penerimaan-logistik', LogistikPenerimaanController::class)->only(['index', 'store', 'update']);
        Route::group(['controller' => LogistikSentToRepairController::class], function () {
            Route::resource('/sent-to-rapair', LogistikSentToRepairController::class)->only(['index', 'update', 'edit']);
            Route::get('/logistik-get-kelengkapan/{id}', 'getKelengkapan');
        });

        Route::group(['controller' => LogistikListCaseRepairController::class], function () {
            Route::get('/list-case-repair', 'index')->name('logistiklcr');
            Route::get('/list-case-repair/{id}', 'pageDetailListCaseLogistik')->name('pageDetailListCaseLogistik');
        });

        Route::group(['controller' => LogistikRequestPaymentController::class], function () {
            Route::resource('/req-payment', LogistikRequestPaymentController::class)->only(['index', 'store']);
            Route::get('/get-data-req-payment/{id}', 'getDataReqPayment');
        });

        // Route lama
        // Route::resource('/validasi', LogistikValidasiProdukController::class)->only(['index', 'store']);
        // Route::get('/getOrderList/{orderId}', [LogistikValidasiProdukController::class, 'getOrderList']);
        // Route::get('/getQtyOrderList/{orderListId}', [LogistikValidasiProdukController::class, 'getQtyOrderList']);
        // Route::get('/testFormId/{orderListId}', [LogistikValidasiProdukController::class, 'testFormId']);
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
                Route::get('/reviewPdfInvoiceLunas/{id}', 'reviewPdfInvoiceLunas')->name('reviewPdfInvoiceLunas');
                Route::get('/invoiceBuktiPembayaran/{id}', 'invoiceBuktiPembayaran')->name('invoiceBuktiPembayaran');
                Route::get('/downloadPdf/{id}', 'downloadPdf')->name('downloadPdf');
                Route::post('/kirimTandaTerima/{id}', 'kirimTandaTerimaCustomer')->name('kirimTandaTerima');
            });

            Route::group(['controller' => KasirRepairController::class], function () {
                Route::resource('/kasir-repair', KasirRepairController::class)->only(['index', 'edit']);
                Route::get('/detail-kasir/{id}', 'detailKasir')->name('detailKasir');
                Route::post('/add-ongkir-repair/{id}', 'createOngkirKasir')->name('createOngkirKasir');
                Route::get('/kasir-ongkir-customer/{encryptId}', 'pageOngkirKasir')->name('pageOngkirKasir');
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
            Route::get('/downloadCustomerByCase', [RepairNonKasirController::class, 'downloadCustomers']);

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

            Route::group(['controller' => RepairRequestPackingController::class], function () {
                Route::resource('/form-req-packing-repair', RepairRequestPackingController::class)->only(['index', 'store']);
                Route::get('/list-req-packing-repair', 'indexLRP')->name('listReqPackingRepair');
            });
        });

        Route::prefix('/teknisi')->group(function () {
            Route::get('/list-cases', [RepairTeknisiLCController::class, 'index'])->name('listCaseTeknisi');
            Route::get('/detail-cases-teknisi/{id}', [RepairTeknisiLCController::class, 'pageDetailCaseTeknisi'])->name('pageDetailCaseTeknisi');
            Route::resource('/new-case-teknisi', RepairTeknisiNCController::class)->only(['index', 'update']);
            Route::resource('/troubleshooting', RepairTroubleshootingController::class)->only(['index', 'update']);
            Route::put('/change-to-estimasi/{id}', [RepairTroubleshootingController::class, 'changeStatus'])->name('change-to-estimasi');

            Route::resource('/pengerjaan', RepairPengerjaanController::class)->only(['index', 'update']);
            Route::get('/detail-pengerjaan-teknisi/{id}', [RepairPengerjaanController::class, 'detailPengerjaan'])->name('detailPengerjaan');
            Route::put('/changeStatusPengerjaan/{id}', [RepairPengerjaanController::class, 'changeStatusPengerjaan'])->name('changeStatusPengerjaan');

            Route::resource('/req-sparepart-teknisi', RepairTeknisiRequestSparepartController::class)->only(['index', 'update']);
        });

        Route::prefix('/estimasi')->group(function () {
            Route::get('dashboard-estimasi', [RepairDashboardEstimasiController::class, 'index'])->name('dashboard-estimasi');
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

            Route::resource('/rubah-estimasi', RepairRubahEstimasiGeneralController::class)->only(['index', 'edit', 'update']);
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
            Route::resource('/konfirmasi-payment', GudangKonfirmasiPembayaran::class)->only(['index', 'store']);
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
                Route::get('/get-id-pembelanjaan/{id}', 'getIdBelanja');
                Route::get('/get-data-pembelanjaan/{id}', 'getDataBelanja');
                Route::get('/print-label/{idBelanja}/{idProduk}', 'printLabel')->name('printLabel');
                Route::get('/review-pdf-label/{idBelanja}/{idProduk}', 'previewLabelPdf')->name('pdf-label-gudang');
            });
            Route::resource('/komplain-supplier', GudangKomplainSupplierController::class)->only(['index']);
        });

        Route::prefix('/produk')->group(function () {
            Route::group(['controller' => GudangListProdukController::class], function () {
                Route::resource('/list-produk', GudangListProdukController::class)->only(['index', 'update']);
                Route::get('/list-produk/search', 'searchListProduk')->name('search.list.produk');
                Route::post('/update-harga-sparepart/{id}', 'updateHarga');
            });
            Route::group(['controller' => GudangSplitPartController::class], function () {
                Route::resource('/split-sku', GudangSplitPartController::class)->only(['index', 'store']);
                Route::get('/get-list-jenis-drone', 'getListJenisDrone');
                Route::get('/get-list-id-item/{id}', 'getListIdItem');
                Route::get('/get-db-id-item/{id}', 'detailBelanjaIdItem');
            });
            Route::resource('/adjust-stock', GudangAdjustStockController::class)->only(['index', 'store']);
            Route::resource('/add-sparepart', GudangAddNewSparepartController::class)->only(['index', 'store']);
        });

        Route::prefix('/distribusi')->group(function () {
            Route::get('/dashboard-distribusi', [GudangDashboardDistributionController::class, 'index'])->name('dashboard-distribusi.index');
            Route::resource('/konfirmasi-pengiriman', GudangKonfirmasiPengirimanController::class)->only(['index', 'edit', 'store']);
            Route::get('/checkCountModal/{id}', [GudangKonfirmasiPengirimanController::class, 'checkCountModal']);
            Route::resource('/retur-sparepart', GudangReturSparepartController::class)->only(['index']);
        });
    });
});
