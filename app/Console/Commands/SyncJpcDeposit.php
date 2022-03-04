<?php

namespace App\Console\Commands;

use App\Payment;
use App\CoinAddress;
use App\Transaction;
use Illuminate\Console\Command;
use App\Repository\Currency\JPCoin;

class SyncJpcDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:jpc-deposit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize jpc deposit amount in users wallet';

    /**
     * Connection to JPC wallet node.
     *
     * @var string
     */
    protected $wallet;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(JPCoin $wallet)
    {
        parent::__construct();
        $this->wallet = $wallet;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $listtransactions = $this->wallet->listtransactions();

        if(!empty($listtransactions)){

            foreach ($listtransactions as $key => $value) {

                if($value['category']=='receive') {

                    $addressExists = Payment::where('reference_no',$value['txid'])
                        ->where('address',$value['address'])
                        ->first();

                    if($addressExists){

                        if($value['confirmations'] >= 1 && $addressExists->confirm == 0){

                            $addressExists->transaction()->update(['status' => 1]);

                            $addressExists->confirm = 1;

                            $addressExists->save();

                        }

                    }else{

                        $coinAddress = CoinAddress::where('address', $value['address'])->first();

                        if($coinAddress){

                            $transaction = Transaction::create([
                                'user_id' => $coinAddress->user_id,
                                'currency_id' => $coinAddress->coin_id,
                                'reference_no' => $value['txid'],
                                'type' => 'Credit',
                                'status' => ($value['confirmations']) ? 1 : 0,
                                'amount' => $value['amount'],
                            ]);

                            $payment = new Payment;
                            $payment->user_id = $coinAddress->user_id;
                            $payment->transaction_id = $transaction->id;
                            $payment->address = $value['address'];
                            $payment->reference_no = $value['txid'];
                            $payment->remarks= "JPCDeposit";
                            $payment->confirm = ($value['confirmations']) ? 1 : 0;
                            $payment->save();
                        }
                    }
                }

            }
        }
    }
}
