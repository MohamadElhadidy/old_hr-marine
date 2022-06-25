<?php


namespace App\Controllers;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;
use App\Auth;

class Profile extends Authenticated
{

    public function my_profileAction()
    {
        $user = Auth::getUser();
        if($user){
            employess::insertNotificationsAdmin($user->id,'  تم  الدخول على الحساب الشخصي ','1','admin','1');
        View::renderTemplate('Profile/my_profile.html');
        }else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function saveProfileAction()
    {
        $user = Auth::getUser();
        if($user){
            $profile = new user($_POST);

            $image =upload_file::upload($_FILES['personal_photo'],'users/');

            $file = null;

            if ($_FILES["personal_photo"]["error"] == 4)
            {
                $file = null;
            }
            else{
                $file =upload_file::upload($_FILES['personal_photo'],'users/');
            }

            $account =$profile->saveProfile($file);

            if ($account) {
                employess::insertNotificationsAdmin($user->id,'  تم  تعديل   الحساب الشخصي ','1','admin','1');
                flash::addMessage("' تم تعديل الحساب بنجاح'", flash::SUCCESS);
                $this->redirect('Profile/my_profile');
            }
        }else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }



}