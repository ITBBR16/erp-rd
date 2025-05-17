<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CertificateMail;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'sender' => 'required|email',
            'body' => 'required|string',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $senderEmail = $request->input('sender');
        $bodyEmail = $request->input('body');

        $pdf = Pdf::loadView('certificate.certificate-template', compact('name'))->setPaper('a4', 'landscape');
        $pdfContent = $pdf->output();

        Mail::send([], [], function ($message) use ($email, $name, $senderEmail, $bodyEmail, $pdfContent) {
            $message->from($senderEmail, 'Certificate Sender')
                    ->to($email)
                    ->subject("Certificate for $name")
                    ->attachData($pdfContent, "Certificate - $name.pdf", [
                        'mime' => 'application/pdf',
                    ])
                    ->setBody($bodyEmail, 'text/html');
        });

        Log::info("Certificate sent to $name <$email> by $senderEmail");
        return response()->json(['message' => 'Sertifikat terkirim ke ' . $email], 200);
    }
}
