<?php

namespace App\Controllers;

use App\Auth;
use App\upload_file;
use \Core\View;
use \App\Models\User;
use \App\flash;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function newAction()
    {
        $user = Auth::getUser();
        if($user->id == '29') {
            View::renderTemplate('Signup/new.html');
        }
        else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }
    }
    public function createAction()
    {
        $user = Auth::getUser();
        if($user->id == '29') {
       $user = new user($_POST);
       $image =upload_file::upload($_FILES['personal_photo'],'users/');

if($image) {
    if ($user->save($image)) {
       // $user->sendActivationEmail();

       // $this->redirect('Signup/success');
        flash::addMessage("'تم إنشاء الحساب بنجاح'", flash::SUCCESS);

        $this->redirect('Signup/new');
    } else {

        View::renderTemplate('Signup/new.html', [
            'user' => $user
        ]);
    }
}
else{

    View::renderTemplate('Signup/new.html',[
        'user' => $user
    ]);
}
        }
        else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }

    }
    public function successAction()
    {
        View::renderTemplate('Signup/success.html');

    }
    public function activateAction()
    {
        User::activate($this->route_params['token']);
        $this->redirect('signup/activated');

    }
    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');

    }

}
