<?php

namespace App\Listeners;

use App\Events\DepositDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Snowfire\Beautymail\Beautymail;

class DepositDoneNotification
{
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
     * @param  DepositDone  $event
     * @return void
     */
    public function handle(DepositDone $event)
    {
        $beautymail = app()->make(BeautyMail::class);
        $symbol = env('TOKEN_SYMBOL');

        $beautymail->send(
            'emails.deposit-done',
            ['payment' => $event->payment, 'locale' => $event->user->language],
            function($message) use ($event,$symbol)
            {
                $message
                    ->to($event->payment->user->email, $event->payment->user->fullName)
                    ->subject('Purchase Successful from '.$symbol);
            });
    }
}
