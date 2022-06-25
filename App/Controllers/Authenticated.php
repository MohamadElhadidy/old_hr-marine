<?php


namespace App\Controllers;

use PDO;
use App\Auth;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Authenticated extends \Core\Controller
{

    protected function before()
    {
        $conn = new PDO("mysql:host=localhost;dbname=hr", 'user', 'password');
        $conn->exec("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        if ($this->requireLogin()){
            $user =Auth::getUser();
            if($user->auth == '4'){
                return true;
            }else{
                if ($this->requireCompany()) {
                    $this->requireCompanyName();
                }
            }
        }
    }
}
