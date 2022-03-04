<?php

namespace App\Listeners;

use App\Events\CoinPurchased;
use Snowfire\Beautymail\Beautymail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoinPurchasedNotification
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
     * @param  CoinPurchased  $event
     * @return void
     */
    public function handle(CoinPurchased $event)
    {
        $beautymail = app()->make(BeautyMail::class);
        $symbol = env('TOKEN_SYMBOL');

        $beautymail->send(
            'emails.coin-bought',
            ['data'=>$event->data, 'user' => $event->user, 'locale' => $event->user->language],
            function($message) use ($event,$symbol)
            {
                $message
                    ->to($event->user->email, $event->user->fullName)
                    ->subject('Purchase Successful from '.$symbol);
            });
    }
}
