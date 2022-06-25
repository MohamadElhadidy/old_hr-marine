<?php


namespace App\Controllers;

use App\Auth;
use App\flash;
use App\Models\employess;
use \Core\View;
use \App\Models\User;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function newAction()
    {
        $this->redirect('Login/index');
    }
     public function indexAction()
    {
        View::renderTemplate('Login/new.html');
    }
                   

    public function CreateAction()
    {
        $user = User::authenticate($_POST['email'],$_POST['password']);
        $remember_me = isset($_POST['remember_me']);
        if($user)
        {
            Auth::login($user,$remember_me);

            employess::insertNotificationsAdmin($user->id,'تم تسجبل الدخول','1','admin','1');
            flash::addMessage("'تم تسجيل الدخول بنجاح'",flash::SUCCESS);
            $this->redirect('Companies/new');

        }
        else{
            $admin = employess::findByColNoCom('1','auth','users');
            employess::insertNotificationsAdmin($admin->id,' هناك محاولة للدخول على حساب'.$_POST['email'],'1','admin','1');
            flash::addMessage("'يرجي التأكد من صحة البيانات'",flash::FAIL);
            View::renderTemplate('Login/new.html',[
                'email' => $_POST['email'],
                'remember_me' => $remember_me

            ]);
        }
    }
    public function LogoutAction()
    {
        $user = Auth::getUser();
        employess::insertNotificationsAdmin($user->id,'  تم تسجيل الخروج ','1','admin','1');
        Auth::logout();
        Auth::companyLogout();
        $this->redirect('Login/show-Logout-Massage');

    }
    public function showLogoutMassageAction()
    {
        flash::addMessage("'تم تسجيل الخروج بنجاح'",flash::SUCCESS);
        $this->redirect('');
    }

}