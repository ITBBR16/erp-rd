<?php

namespace App\Services\repair;

use App\Repositories\repair\repository\RepairCustomerReviewRepository;
use Exception;
use Illuminate\Http\Request;

class RepairCustomerReviewService
{
    protected $customerReview;

    public function __construct(RepairCustomerReviewRepository $repairCustomerReviewRepository)
    {
        $this->customerReview = $repairCustomerReviewRepository;
    }

    public function createNewReview(Request $request)
    {
        $this->customerReview->beginTransaction();
        
        try {
            $validation = $request->validate([
                'rating_tingkat_ps' => 'required|integer|min:1|max:5',
                'rating_kecepatan_respon' => 'required|integer|min:1|max:5',
                'rating_kecepatan_ts' => 'required|integer|min:1|max:5',
                'rating_kecepatan_pengerjaan' => 'required|integer|min:1|max:5',
                'rating_kebersihan' => 'required|integer|min:1|max:5',
                'rating_kualitas_hasil' => 'required|integer|min:1|max:5',
                'pelayanan' => 'required|array|min:1|max:1',
                'rating_tingkat_pelayanan' => 'required|integer|min:1|max:5',
                'kembali_lagi' => 'required|array|min:1|max:1',
                'kritik' => 'required',
                'saran' => 'required',
            ]);

            $today = date('Y-m-d');
            $existingReview = $this->customerReview->findReviewByCaseIdAndDate($request->input('no_case'), $today);

            if ($existingReview) {
                return ['status' => 'error', 'message' => 'Terimakasih review sudah terisi.'];
            }

            $dataReview = [
                'case_id' => $request->input('no_case'),
                'problem_solved' => $validation['rating_tingkat_ps'],
                'kecepatan_respon' => $validation['rating_kecepatan_respon'],
                'kecepatan_ts' => $validation['rating_kecepatan_ts'],
                'kecepatan_pengerjaan' => $validation['rating_kecepatan_pengerjaan'],
                'kualitas_kebersihan' => $validation['rating_kebersihan'],
                'kualitas_hasil' => $validation['rating_kualitas_hasil'],
                'pelayanan_diharapkan' => $validation['pelayanan'][0],
                'tingkat_pelayanan' => $validation['rating_tingkat_pelayanan'],
                'kembali_datang' => $validation['kembali_lagi'][0],
                'kritik' => $validation['kritik'],
                'saran' => $validation['saran'],
            ];

            $this->customerReview->storeReview($dataReview);

            $this->customerReview->commitTransaction();
            return ['status' => 'success', 'message' => 'Terima kasih atas review Anda!'];

        } catch (Exception $e) {
            $this->customerReview->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }

    }

    public function findReview($noCase, $today)
    {
        $existingReview = $this->customerReview->findReviewByCaseIdAndDate($noCase, $today);

        if ($existingReview) {
            return ['status' => 'ada'];
        } else {
            return ['status' => 'belum'];
        }

    }

    // public function findCase($noCase)
    // {
    //     $existingCase = $this->customerReview;
    // }

}