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

    public function edit($increment)
    {
        $pos = strpos($increment, 'RD');

        if ($pos !== false) {
            $noCase = substr($increment, $pos + 2);
        } else {
            $noCase = $increment;
        }
        return view('repair.review.review-customer', [
            'title' => 'Customer Review',
            'noCase' => $noCase,
        ]);
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
    
            $message = 'https://stagging.rumahdrone.id/review-customer/' . $formatUrl . '/edit';
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
