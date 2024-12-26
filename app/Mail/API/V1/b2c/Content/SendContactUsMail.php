<?php

namespace App\Mail\API\V1\b2c\Content;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * @author Salah Derbas
     */
    public $data;
    public function __construct($data)
    {
        $this->data  = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @author Salah Derbas
     */
    public function build()
    {
        Log::channel('B2C-API')->debug("[data: " . $this->data. "] SendContactUsMail");
        return $this->from( env('MAIL_FROM_ADDRESS') )->subject('Contact Us')->view('emails/contact_us_email')->with('data', $this->data);
    }
}
