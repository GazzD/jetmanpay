<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedClaim extends Mailable
{
    use Queueable, SerializesModels;

    public $claimId;
    public $subject = 'Reclamo creado';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($claimId)
    {
        $this->claimId = $claimId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.created-claim')
            ->with('claimId',$this->claimId)
            ;
    }
}
