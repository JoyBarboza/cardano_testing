<?php namespace App\Http\Controllers;

use App\Recipient;
use Illuminate\Http\Request;
use App\Http\Requests\EmailFormRequest;
use Illuminate\Database\QueryException;
use App\Repository\Message\IMessageRepository;

class MessageController extends Controller
{
    protected $repository;

    public function __construct(IMessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function inbox()
    {
        $recipient = auth()->user()->recipient()
            ->inbox()->latest()->paginate(20);
        return view('message.uinbox', compact('recipient'));
    }

    public function show($message)
    {
        $reciever = Recipient::find($message);

        if(!$reciever) {
            return redirect('message');
        }
        $reciever->is_read = 1;
        $reciever->save();
        return view('message.uview', compact('reciever'));
    }

    public function trash()
    {
        $recipient = auth()->user()->recipient()
            ->trash()->latest()->paginate(20);

        return view('message.trash', compact('recipient'));
    }

    public function setStarred(Request $request)
    {
        $reciever = Recipient::find($request->messageID);
        $output = null;
        if(!$reciever) {
            $output = ['class' => ''];
        } else if($reciever->is_starred) {
            $reciever->is_starred = 0;
            $output = ['class' => ''];
        } else {
            $reciever->is_starred = 1;
            $output = ['class' => 'inbox-started'];
        }

        $reciever->save();

        return json_encode($output);
    }

    public function destroy(Request $request)
    {
        Recipient::whereIn('id', $request->ids)->update([
            'placeholder' => 'trash'
        ]);

        return json_encode(['status' => true]);
    }

    public function destroyPermanent(Request $request)
    {
        Recipient::whereIn('id', $request->ids)->delete();

        return json_encode(['status' => true]);
    }

    public function markAsRead(Request $request)
    {
        Recipient::whereIn('id', $request->ids)->update([
            'is_read' => 1
        ]);

        return json_encode(['status' => true]);
    }
}
