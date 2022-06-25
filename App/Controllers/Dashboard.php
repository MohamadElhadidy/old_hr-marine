<?php


namespace App\Controllers;
use App\Auth;
use App\Models\employess;
use \Core\View;


class Dashboard extends Authenticated
{
    public function indexAction()
    {
         View::renderTemplate('Dashboard/index.php');

        
    }
     public function newAction()
    {
       View::renderTemplate('Dashboard/index.php');
    }
    

}





