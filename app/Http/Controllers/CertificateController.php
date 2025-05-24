<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CertificateMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CertificateController extends Controller
{
    public function previewSertificate()
    {
        $dataView = [
            'name' => 'Daniel Imam Supomo, St. Pd.'
        ];

        $pdf = Pdf::loadView('certificate.certificate-template', $dataView)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function sendSertificate(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'sender' => 'required|email',
                'title' => 'required|string',
                'body' => 'required|string',
            ]);

            $name = $request->input('name');
            $email = $request->input('email');
            $senderEmail = $request->input('sender');
            $titleEmail = $request->input('title');
            $bodyEmail = $request->input('body');

            $pdf = Pdf::loadView('certificate.certificate-template', compact('name'))->setPaper('a4', 'landscape');
            $pdfContent = $pdf->output();

        
            Mail::send([], [], function ($message) use ($email, $name, $senderEmail, $titleEmail, $bodyEmail, $pdfContent) {
                $message->from($senderEmail, $titleEmail)
                        ->to($email)
                        ->subject("Certificate for $name")
                        ->attachData($pdfContent, "Certificate - $name.pdf", [
                            'mime' => 'application/pdf',
                        ])
                        ->html($bodyEmail);
            });
    
            Log::info("Certificate sent to $name <$email> by $senderEmail");
            return response()->json(['message' => 'Sertifikat terkirim ke ' . $email], 200);

        } catch (Exception $e) {
            Log::error('Error in sendSertificate: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
