<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralLink extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $wing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $wing)
    {
        $this->user = $user;
       
            $this->wing = $user->referral;
        

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.referral');
    }
}
