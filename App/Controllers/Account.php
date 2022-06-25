<?php


namespace App\Controllers;

use App\Models\employess;
use App\Models\User;
use \Core\View;
use App\Auth;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Account extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function ValidateEmailAction()
    {
        $is_valid = ! User::email_Exists($_GET['email']);
        header('Content_Type: application/json');
        echo json_encode($is_valid);
    }

    public function ValidateAction()
    {
        $param =Auth::param();
        $param2 = explode('=',urldecode($param[1]));

        $is_valid = ! employess::Exists($param2[1], $param2[0],$param[0]);
        header('Content_Type: application/json');
        echo json_encode($is_valid);

    }
    public function ValidateEditAction()
    {
        $param =Auth::param();

        $param2 = explode('=',urldecode($param[2]));

        if($param[1] == $param2[1])
        {
            $is_valid = true;
        }
        else {
            $is_valid = !employess::Exists($param2[1], $param2[0], $param[0]);
        }
        header('Content_Type: application/json');
        echo json_encode($is_valid);

    }

    public function ValidateEditUserAction()
    {
        $param =Auth::param();

        $param2 = explode('=',urldecode($param[2]));

        if($param[1] == $param2[1])
        {
            $is_valid = true;
        }
        else {
            $is_valid = !User::ExistsUser($param2[1], $param2[0]);
        }
        header('Content_Type: application/json');
        echo json_encode($is_valid);

    }




}
