<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\Presale;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $transaction, $btcWallet, $wtcWallet;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function index()
    {
        $transaction = new Transaction();

        $data = [
            'usdBalance' => ($transaction->creditTotal('USD') - $transaction->debitTotal('USD')),
            'usdDeposit' => $transaction->creditTotal('USD'),
            'usdWithdraw' => $transaction->debitTotal('USD'),
            'mscBalance' => ($transaction->creditTotal('CSM') - $transaction->debitTotal('CSM')),
            'mscDeposit' => $transaction->creditTotal('CSM'),
            'mscWithdraw' => $transaction->debitTotal('CSM'),
            'joinedTotal' => User::count(),
            'joinedLastMonth' => User::whereDate('created_at', '>=', Carbon::now()->subMonth(1))->count(),
            'joinedYesterday' => User::whereDate('created_at', '>=', Carbon::now()->subDays(1))->count()
        ];

        return view('dashboard', $data);
    }

    public function revenueChart()
    {
        return Transaction::revenueChart()->toJson();
    }

    public function transactionChart()
    {
        return json_encode([
            'usd' => Transaction::amountChart('usd'),
            'csm' => Transaction::amountChart('csm'),
        ]);
    }
}
