<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateMail;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'nama' => 'required',
            'email' => 'required'
        ]);

        $name = $request->nama;
        $email = $request->email;

        $pdf = PDF::loadView('certificate.certificate-template', compact('name'));
        $pdfData = $pdf->output();

        Mail::to($email)->send(new CertificateMail($name, $pdfData));

        return response()->json(['message' => 'Sertifikat terkirim ke ' . $email], 200);
    }
}
