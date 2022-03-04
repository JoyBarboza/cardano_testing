<?php

namespace App\Listeners;

use App\Events\Registered;
use App\Mail\VerificationMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Snowfire\Beautymail\Beautymail;

class SendRegistrationNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $this->user = $event->user;

        $beautymail = app()->make(Beautymail::class);

        $beautymail->send('emails.welcome', ['token'=>$this->user->verification_token, 'locale' => $event->locale], function($message)
        {
            $message->to($this->user->email, $this->user->fullName)->subject('Hi! '.$this->user->first_name.',');
        });
        
       // ->from('aivie.its@itspectrumsolutions.com', 'MasoniCoin Team')
    }
}
