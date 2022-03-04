<?php
/**
 * Created by PhpStorm.
 * User: amit
 * Date: 14/6/17
 * Time: 4:03 PM
 */

namespace App\Repository\Message;

use App\Message;
use App\Recipient;
use App\User;
use Illuminate\Support\Facades\Mail;

class MessageRepository implements IMessageRepository
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->message, $method], $args);
    }

    public function sendMessage(array $data)
    {
        $message = $this->message->create([
            'author_id' => auth()->id(),
            'subject' => $data['subject'],
            'body' => $data['message'],
        ]);
        
        if(is_array($data['to'])) {
            $recievers = $data['to'];
        } else if($data['to'] == 'all') {
            $recievers = User::exceptMe()->pluck('id')->toArray();
        } else if($data['to'] == 'active') {
            $recievers = User::whereHas('subscription')->exceptMe()->pluck('id')->toArray();
        } else {
            $recievers = User::whereDoesntHave('subscription')->exceptMe()->pluck('id')->toArray();
        }
        
        $reciepents = [];
        
        foreach($recievers as $reciever) {
            array_push($reciepents, new Recipient([
                'user_id' => $reciever,
                'placeholder' => 'inbox',
            ]));
        }

        array_push($reciepents, new Recipient([
            'user_id' => auth()->id(),
            'placeholder' => 'sent',
        ]));

        $message->recipient()->saveMany($reciepents);

    }
}