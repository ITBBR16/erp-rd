<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $pdfContent;

    public function __construct($name, $pdfContent)
    {
        $this->name = $name;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->subject('Sertifikat Webinar DJI Mavic 4 Pro')
                    ->view('emails.certificate')
                    ->attachData($this->pdfContent, 'sertifikat-'.$this->name.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
