<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use Illuminate\Validation\Rule;
use App\Models\kios\KiosPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosOrderSecond;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosMetodePembayaran;
use App\Repositories\kios\KiosRepository;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\kios\KiosMetodePembayaranSecond;

class KiosPaymentController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $payment = KiosPayment::with('order.supplier', 'metodepembayaran', 'ordersecond', 'metodepembayaransecond')->get();

        return view('kios.shop.payment.payment', [
            'title' => 'Payment',
            'active' => 'payment',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'payment' => $payment,
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
            $divisi = $this->suppKiosRepo->getDivisi($user);
            $divisiName = $divisi->nama;
            $tanggal = Carbon::now();
            $tanggal->setTimezone('Asia/Jakarta');
            $formattedDate = $tanggal->format('d/m/Y H:i:s');
            $kiosPayment = KiosPayment::findOrFail($id);
            $orderId = $request->input('order_id');
            $statusOrder = $request->input('status_order');
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
                'media_transaksi' => $request->input('media_transaksi'),
                'no_rek' => $request->input('no_rek'),
                'nama_akun' => $request->input('nama_akun'),
                'nilai_belanja' => $totalBelanja,
                'ongkir' => $totalOngkir,
                'pajak' => $totalPajak,
                'keterangan' => $keteranganFinance . ", " . $request->input('keterangan'),
            ];

            $responseFinance = Http::post($urlFinance, $dataFinance);
            $statusResponse = json_decode($responseFinance->body(), true);
            $feedbackStatus = $statusResponse['status'];

            if($feedbackStatus == 'success') {

                $kiosPayment->keterangan = $request->input('keterangan');
                $kiosPayment->tanggal_request = $tanggal;
                $kiosPayment->status = 'Waiting For Payment';

                // Message to finance group
                if($statusOrder == 'Baru') {
                    $orderBaru = KiosOrder::findOrFail($orderId);
                    $orderBaru->status = 'Waiting For Payment';
                    $orderBaru->save();
                    $linkDrive = $orderBaru->link_drive;

                    PengirimanEkspedisi::create([
                        'divisi_id' => $divisiId,
                        'order_id' => $orderId,
                        'status_order' => 'Baru',
                        'status' => 'Belum Dikirim',
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
                    'no_telp' => '6285156519066',
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
            
            if($request->has('new-metode-payment-edit')){
                if($statusOrder === 'Baru') {
                    $validate = $request->validate([
                                    'supplier_id' => 'required',
                                    'media_pembayaran' => 'required',
                                    'no_rek' => ['required', Rule::unique('rumahdrone_kios.metode_pembayaran_supplier', 'no_rek')],
                                    'nama_akun' => 'required',
                                ]);
        
                    $metodePembayaran = KiosMetodePembayaran::create($validate);
                    $kiosPayment->metode_pembayaran_id = $metodePembayaran->id;
                    $kiosPayment->save();
                } else {
                    $validate = $request->validate([
                        'customer_id' => 'required',
                        'media_pembayaran' => 'required',
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

    public function updatePayment($id)
    {
        $paymentKios = KiosPayment::findOrFail($id);
        $paymentKios->status = 'Paid';

        return response()->json(['message' => 'Product status updated successfully']);
    }

}
