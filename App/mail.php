<?php


namespace App;
use App\Config;
use Mailgun\Mailgun;

class mail
{

public static function send($to,$subject,$text,$html)
{
    $headers = 'Content-Type: text/html;; charset=utf-8' . "\r\n";
    $headers .= 'Content-Transfer-Encoding: base64' . "\r\n";
    $headers .= 'From: requests.system@Marine-co.com';
    mail($to,$subject,$html, $headers);
}
}