<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\repair\RepairCustomerReviewService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class ReviewCustomerController extends Controller
{

    protected $customerReview;
    public function __construct(RepairCustomerReviewService $repairCustomerReviewService)
    {
        $this->customerReview = $repairCustomerReviewService;
    }

    public function index($increment)
    {
        $pos = strpos($increment, 'RD');
        $today = date('Y-m-d');

        if ($pos !== false) {
            $noCase = substr($increment, $pos + 2);
        } else {
            $noCase = $increment;
        }

        $resultFind = $this->customerReview->findReview($noCase, $today);

        if ($resultFind['status'] == 'ada') {
            return view('repair.review.done-review', [
                'title' => 'Customer Review',
                'noCase' => $noCase,
            ]);
        } else {
            return view('repair.review.review-customer', [
                'title' => 'Customer Review',
                'noCase' => $noCase,
            ]);

        }

    }

    public function store(Request $request)
    {
        // dd($request);
        $resultReview = $this->customerReview->createNewReview($request);

        if ($resultReview['status'] === 'success') {
            return back()->with('success', $resultReview['message']);
        } else {
            return back()->with('error', $resultReview['message']);
        }
    }

    public function sendWhatsapp(Request $request)
    {
        try {

            $noNota = $request->input('noNota');
            $noTelpon = $request->input('noTelpon');
            $tanggal = Carbon::now();
            $tanggal->setTimezone('Asia/Jakarta');
            $formattedDate = $tanggal->format('dmYHis');
            $formatUrl = $formattedDate . 'RD' . $noNota;
    
            $linkReview = 'https://stagging.rumahdrone.id/review-customer/' . $formatUrl;
            $message = "Terima kasih telah mempercayakan kami untuk kebutuhan Anda!\n
                    Jika Anda puas dengan layanan/produk kami, kami sangat menghargai jika Anda bisa meluangkan waktu untuk memberikan ulasan atau masukan.
                    Hal ini akan sangat membantu kami untuk terus meningkatkan kualitas pelayanan kami.\n
                    Berikut link ulasan kami :\n" .
                    $linkReview . "\nTerima kasih banyak!";
            $urlWaApi = 'https://script.google.com/macros/s/AKfycbyC2ojngj6cSxq2kqW3H_wT-FjFBQrCL7oGW9dsFMwIC-JV89B-8gvwp54qX-pvnNeclg/exec';
            $dataWa = [
                'no_telpon' => $noTelpon,
                'pesan' => $message
            ];
    
            $response = Http::post($urlWaApi, $dataWa);

            return response()->json(['status' => 'success', 'message' => 'Success Send Review']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }
}
