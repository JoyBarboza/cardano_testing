<?php

namespace App\Http\Controllers;

use App\Mail\ReferralLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReferralController extends Controller
{
    public function index()
    {
        return view('admin.referral')->with([
            'user' => auth()->user()
        ]);
    }

    public function sendMail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'wing' => 'required'
        ]);

        $user = auth()->user();

        try {
            Mail::to([$request->input('email')])
                ->queue(new ReferralLink($user, $request->input('wing')));
        } catch (\Exception $exception) {
            return json_encode(['status' => false, 'message' => 'Mail Delivery failed']);
        }
        return json_encode(['status' => true, 'message' => 'Mail has been sent']);
    }
}
