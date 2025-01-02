<?php

namespace App\Jobs\API\V1\b2b\Auth;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\API\V1\b2b\Auth\SendOTPEmailMail;

class SendOTPEmailJob implements ShouldQueue
{
    use Queueable;
    protected $email;
    protected $otp;
    /**
     * Create a new job instance.
     */
    public function __construct($email , $otp)
    {
        $this->email = $email;
        $this->otp   = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = ['email' => $this->email , 'otp'=> $this->otp ];
        // Mail::to( $this->email )->send( new SendOTPEmailMail($data) );
    }
}
