<?php


namespace App\Controllers;

use App\flash;
use App\Models\employess;
use Core\Controller;
use \Core\View;
use App\Auth;
use App\Models\User;


class Companies extends Controller
{
    public function newAction()
    {
        if (isset($_COOKIE['company'])){Auth::companyLogout();}
        $user = Auth::getUser();
        if($user) {
            employess::insertNotificationsAdmin($user->id,'تم  الدخول على صفحة أختر الشركة','1','admin','1');
            View::renderTemplate('Companies/new.html');
        }else{
            flash::addMessage("'سجل دخولك أولا'",flash::INFO);
            $this->redirect('Login/new');
        }
    }
    public function reportAction()
    {
        Auth::company($_POST['id']);
       $user=Auth::getUser();
       if($user){
           employess::insertNotificationsAdmin($user->id, 'تم  الدخول على شركة', '1', 'admin', $_POST['id']);
       }
        $this->redirectRequestUrl(Auth::getReturnToPage());
    }
	
	 public  function onlineAction()
    {
        $view = new User($_POST);
        $view->online();
    }

}