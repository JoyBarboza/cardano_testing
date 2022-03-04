<?php

namespace App\Http\Controllers\Nft;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\Presale;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // return 1;die;
        return view('nft.dashboard');
    }
}
