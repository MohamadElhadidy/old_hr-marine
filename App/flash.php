<?php


namespace App;


class flash
{
    const SUCCESS ="'success'";
    const INFO ="'warning'";
    const FAIL ="'danger'";
    const NOTIFICATION ="'primary'";

    public static function addMessage($message, $type ="'success'")
{
    if(! isset($_SESSION['flash_notification'])){
        $_SESSION['flash_notification'] = [];
    }
    $_SESSION['flash_notification'] = [];

    array_push($_SESSION['flash_notification'], [
            'body'=>$message,
            'type'=> $type
        ]);
}
    public static function getMessage()
    {
        if(isset($_SESSION['flash_notification'])){
            $messages =$_SESSION['flash_notification'];
            unset($_SESSION['flash_notification']);
            return  $messages;
        }
    }
}