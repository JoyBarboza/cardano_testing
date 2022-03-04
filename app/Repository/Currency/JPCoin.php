<?php

namespace App\Repository\Currency;

use SSH2;


class JPCoin
{
    private $ssh;

    const LOCATION = './jpcoin/src/jpcoind ';

    public function __construct()
    {
        $this->ssh = new SSH2('45.76.102.130');
        $this->connect();
    }

    public function isValidAddress($address)
    {
        $return = $this->ssh->exec(self::LOCATION.'validateaddress '.$address);
        $data = json_decode($return);
        return $data->isvalid;
    }

    public function connect()
    {
        if (!$this->ssh->login('root', '2?Muk5-jV=1bx{rc')) {
            die('Error! Connection to Wallet failed');
        }
    }

    public function getNewAddress()
    {
        return $this->ssh->exec(self::LOCATION.'getnewaddress');
    }

    public function sendToAddress($coinAddress, $amount)
    {
		$command = self::LOCATION.'sendtoaddress '.$coinAddress.' '.$amount;
		
		$command = str_replace("\n", "", $command);
		$command = str_replace("\r", "", $command);

		$return  = $this->ssh->exec($command);
        if (strpos($return, 'message') == false) {
            return ['hash' => $return, 'message' => 'success'];
        }else{
            $msg =  str_replace("error:","",$return);
            $jsonDcode = json_decode($msg, true);
            return ['hash' => null, 'message' => $jsonDcode['message']];
        }
    }

    public function listReceivedByAddress()
    {
        $return = $this->ssh->exec(self::LOCATION.'listreceivedbyaddress');
        return json_decode($return,true);
    }

    public function getTransaction($txn)
    {

        $return = $this->ssh->exec(self::LOCATION.'gettransaction '.$txn);
        return json_decode($return,true);
    }

    public function getBalance()
    {
        $return = $this->ssh->exec(self::LOCATION.'getbalance');
        return json_decode($return,true);
    }

    public function listTransactions($account = '*', $limit = 100000, $offset = 0)
    {
        $commandString = self::LOCATION.'listtransactions "'.$account.'" '.$limit.' '.$offset;
        $return = $this->ssh->exec($commandString);
        return json_decode($return,true);
    }
}