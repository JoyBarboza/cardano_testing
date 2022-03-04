<?php
/**
 * Created by PhpStorm.
 * User: amit
 * Date: 14/6/17
 * Time: 4:01 PM
 */
namespace App\Repository\Message;

interface IMessageRepository
{
    public function sendMessage(array $data);
}