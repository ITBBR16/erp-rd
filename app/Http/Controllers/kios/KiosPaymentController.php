<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use Illuminate\Validation\Rule;
use App\Models\kios\KiosPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosMetodePembayaran;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\kios\KiosMetodePembayaranSecond;
use App\Models\management\AkuntanAkunBank;
use App\Repositories\umum\UmumRepository;

class KiosPaymentController extends Controller
{
    public function __construct(
        private UmumRepository $umum
    ) {}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $daftarAkun = AkuntanAkunBank::all();
        $payment = KiosPayment::with('order.supplier', 'metodepembayaran', 'ordersecond', 'metodepembayaransecond')->get();

        return view('kios.shop.payment.payment', [
            'title' => 'Payment',
            'active' => 'payment',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'payment' => $payment,
            'daftarAkun' => $daftarAkun
        ]);
    }

    public function validasi(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionEkspedisi = DB::connection('rumahdrone_ekspedisi');
        $connectionKios->beginTransaction();
        $connectionEkspedisi->beginTransaction();

        try {
            $request->validate([
                'media_transaksi' => 'required',
                'no_rek' => 'required',
                'nama_akun' => 'required',
            ]);
            $user = auth()->user();
            $divisiId = $user->divisi_id;
            $divisi = $this->umum->getDivisi($user);
            $divisiName = $divisi->nama;
            $tanggal = Carbon::now();
            $tanggal->setTimezone('Asia/Jakarta');
            $formattedDate = $tanggal->format('d/m/Y H:i:s');
            $statusOrder = $request->input('status_order');
            $kiosPayment = KiosPayment::findOrFail($id);
            $dataMPBaru = $kiosPayment->metodepembayaran;
            $dataMPSecond = $kiosPayment->metodepembayaransecond;
            $ssMediaTransaksi = ($statusOrder == 'Baru') ? $dataMPBaru->akunBank->nama : $dataMPSecond->media_pembayaran;
            $ssNamaAkun = ($statusOrder == 'Baru') ? $dataMPBaru->nama_akun : $dataMPSecond->nama_akun;
            $ssNoRek = ($statusOrder == 'Baru') ? $dataMPBaru->no_rek : $dataMPSecond->no_rek;

            $orderId = $request->input('order_id');
            $noTransaksi = ($statusOrder == 'Baru') ? 'KiosBaru-' . $id : 'KiosBekas-' . $id;
            $keteranganFinance = ($statusOrder == 'Baru') ? 'Order Id N.' . $id : 'Order Id S.' . $id;

            $totalBelanja = preg_replace("/[^0-9]/", "", $request->input('nilai_belanja'));
            $totalOngkir = preg_replace("/[^0-9]/", "", $request->input('ongkir'));
            $totalPajak = preg_replace("/[^0-9]/", "", $request->input('pajak'));

            $urlFinance = 'https://script.google.com/macros/s/AKfycbwnOPiXx_1ef6O_3krVTxcvA6WW8XrX_A6HwsSxi3vVGjkB_dfoLOBTg05sOA0SCY8Emw/exec';
            $dataFinance = [
                'tanggal' => $formattedDate,
                'divisi' => $divisiName,
                'no_transaksi' => $noTransaksi,
                'media_transaksi' => $ssMediaTransaksi,
                'no_rek' => $ssNoRek,
                'nama_akun' => $ssNamaAkun,
                'nilai_belanja' => $totalBelanja,
                'ongkir' => $totalOngkir,
                'pajak' => $totalPajak,
                'keterangan' => $keteranganFinance . ", " . $request->input('keterangan'),
            ];

            $responseFinance = Http::post($urlFinance, $dataFinance);
            $statusResponse = json_decode($responseFinance->body(), true);
            $feedbackStatus = $statusResponse['status'];

            if ($feedbackStatus == 'success') {

                $kiosPayment->keterangan = $request->input('keterangan');
                $kiosPayment->tanggal_request = $tanggal;
                $kiosPayment->status = 'Waiting For Payment';

                // Message to finance group
                if ($statusOrder == 'Baru') {
                    $orderBaru = KiosOrder::findOrFail($orderId);
                    $orderBaru->status = 'Waiting For Payment';
                    $orderBaru->save();
                    $linkDrive = $orderBaru->link_drive;

                    PengirimanEkspedisi::create([
                        'divisi_id' => $divisiId,
                        'order_id' => $orderId,
                        'status_order' => 'Baru',
                        'status' => 'Belum Terverifikasi',
                    ]);
                } else {
                    $orderSecond = KiosOrderSecond::findOrFail($orderId);
                    $orderSecond->status = 'Waiting For Payment';
                    $orderSecond->save();
                    $linkDrive = $orderSecond->link_drive;
                }

                $kiosPayment->save();
                $totalPembayaran = $totalBelanja + $totalOngkir + $totalPajak;
                $formattedTotal = number_format($totalPembayaran, 0, ',', '.');
                $msgOrderId = ($statusOrder == 'Baru') ? 'N.' . $orderId : 'S.' . $orderId;
                $namaGroup = '';
                $header = "*Incoming Request Payment Produk " . $statusOrder . "*\n\n";
                $body = "Order ID : " . $msgOrderId . "\nRef : " . $noTransaksi . "\nTotal Nominal : Rp. " . $formattedTotal . "\nLink Order ID : " . $linkDrive;
                $footer = "\nDitunggu paymentnya kakak 😘\nJangan lupa upload bukti transfer di link drive yaa\n";
                $message = $header . $body . $footer;

                $urlMessage = 'https://script.google.com/macros/s/AKfycbxX0SumzrsaMm-1tHW_LKVqPZdIUG8sdp07QBgqmDsDQDIRh2RHZj5gKZMhAb-R1NgB6A/exec';
                $messageFinance = [
                    'no_telpon' => '6285156519066',
                    'pesan' => $message,
                ];

                $responseMessage = Http::post($urlMessage, $messageFinance);

                $connectionKios->commit();
                $connectionEkspedisi->commit();

                return back()->with('success', 'Success Request Payment.');
            } else {
                $connectionKios->rollBack();
                $connectionEkspedisi->rollBack();
                return back()->with('error', 'Tidak bisa melakukan request payment.');
            }
        } catch (Exception $e) {
            $connectionKios->rollBack();
            $connectionEkspedisi->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $kiosPayment = KiosPayment::findOrFail($id);

            $ongkir = preg_replace("/[^0-9]/", "", $request->input('ongkir'));
            $pajak = preg_replace("/[^0-9]/", "", $request->input('pajak'));
            $statusOrder = $request->input('status_order');

            if ($request->has('new-metode-payment-edit')) {
                if ($statusOrder === 'Baru') {
                    $validate = $request->validate([
                        'supplier_id' => 'required',
                        'akun_bank_id' => 'required',
                        'no_rek' => ['required', Rule::unique('rumahdrone_kios.kios_metode_pembayaran_supplier', 'no_rek')],
                        'nama_akun' => 'required',
                    ]);

                    $metodePembayaran = KiosMetodePembayaran::create($validate);
                    $kiosPayment->metode_pembayaran_id = $metodePembayaran->id;
                    $kiosPayment->save();
                } else {
                    $validate = $request->validate([
                        'customer_id' => 'required',
                        'akun_bank_id' => 'required',
                        'no_rek' => ['required', Rule::unique('rumahdrone_kios.kios_metode_pembayaran_second', 'no_rek')],
                        'nama_akun' => 'required',
                    ]);

                    $metodePembayaran = KiosMetodePembayaranSecond::create($validate);
                    $kiosPayment->metode_pembayaran_id = $metodePembayaran->id;
                    $kiosPayment->save();
                }
            }

            $jenisPembayaran = [];
            $jenisPembayaran[] = 'Pembelian Barang';

            if ($ongkir > 0) {
                $jenisPembayaran[] = 'Ongkir';
            }

            if ($pajak > 0) {
                $jenisPembayaran[] = 'Pajak';
            }

            $jenisPembayaranStr = implode(', ', $jenisPembayaran);

            $kiosPayment->update([
                'jenis_pembayaran' => $jenisPembayaranStr,
                'ongkir' => $ongkir,
                'pajak' => $pajak,
            ]);

            $connectionKios->commit();
            return back()->with('success', 'Success Update Data Payment.');
        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updatePayment(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionEkspedisi = DB::connection('rumahdrone_ekspedisi');
        $connectionKios->beginTransaction();
        $connectionEkspedisi->beginTransaction();

        try {
            $paymentKios = KiosPayment::findOrFail($id);

            if ($paymentKios) {
                if ($paymentKios->order_type == 'Baru') {
                    $updateStatus = $paymentKios->order;

                    if ($updateStatus) {
                        PengirimanEkspedisi::create([
                            'divisi_id' => 1,
                            'order_id' => $paymentKios->order_id,
                            'status_order' => 'Baru',
                            'status' => 'Belum Dikirim',
                        ]);
                        $updateStatus->update(['status' => 'Belum Dikirim']);
                    } else {
                        throw new \Exception('Order not found');
                    }
                } elseif ($paymentKios->order_type == 'Bekas') {
                    $updateStatus = $paymentKios->ordersecond;

                    if ($updateStatus) {
                        if ($paymentKios->ongkir > 0) {
                            PengirimanEkspedisi::create([
                                'divisi_id' => 1,
                                'order_id' => $paymentKios->order_id,
                                'status_order' => 'Bekas',
                                'status' => 'Belum Dikirim',
                            ]);
                            $updateStatus->update(['status' => 'Belum Dikirim']);
                        } else {
                            $updateStatus->update(['status_pembayaran' => 'Paid', 'status' => 'Proses QC']);
                        }
                    } else {
                        throw new \Exception('OrderSecond not found');
                    }
                } else {
                    throw new \Exception('Invalid order type');
                }

                // Update paymentKios status to Paid
                $paymentKios->update(['status' => 'Paid']);

                $connectionKios->commit();
                $connectionEkspedisi->commit();
                return response()->json(['status' => 'success', 'message' => 'Success verification']);
            } else {
                throw new \Exception('PaymentKios data not found');
            }
        } catch (\Exception $e) {
            $connectionKios->rollBack();
            $connectionEkspedisi->rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
