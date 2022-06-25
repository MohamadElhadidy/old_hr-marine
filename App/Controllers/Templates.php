<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class templates extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم   الدخول على  إضافة نموذج  ','1','templates','1');
            View::renderTemplate('templates/upload.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض الدخول على  إضافة نموذج  ','1','templates','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function saveTemplateAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '3')){
        $data = new employess($_POST);

        $path = "templates/";

        $file = upload_file::upload($_FILES['file'], $path);


        if ($file) {

            if ($data->saveTemplate($file)) {

                flash::addMessage("'تم  إضافة نموذج '", flash::SUCCESS);
                $this->redirect('templates/upload');
            }

        }
        else{
            flash::addMessage("'يرجى إعادة  إضافة النموذج '", flash::FAIL);
            $this->redirect('templates/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض    إضافة نموذج  ','1','templates','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $this->redirect('templates/download');

    }
    public function downloadAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على تقرير النماذج  ','1','templates','1');
            View::renderTemplate('templates/download.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض الدخول على تقرير النماذج  ','1','templates','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function deleteTemplateAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '5')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?',$url);

            if ($data->deleteTemplate($param[1])) {

                flash::addMessage("'تم حذف  النموذج بنجاح  '", flash::FAIL);
                $this->redirect('templates/download');
            }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم  رفض   حذف نموذج  ','1','templates','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }

    }
    public  function getTemplateAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '4')){
            $url = Auth::url();
            $param = explode('?', $url);

            $templates = employess::findById($param[1], 'templates');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تعديل نموذج  '.$templates->name,'1','templates','1');
            view::renderTemplate('templates/edit.html', [
                'data' => $templates
            ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تعديل نموذج  ','1','templates','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function editTemplateAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '4')){
            $data = new employess($_POST);
            $file = null;

            if ($_FILES["file"]["error"] == 4)
            {
                $file = null;
            }
            else{
                $file = upload_file::upload($_FILES['file'], 'templates/');
            }

            if ($data->editTemplate($file)) {

                flash::addMessage("'تم تعديل النموذج   بنجاح  '", flash::SUCCESS);
                $this->redirect('templates/download');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض تعديل نموذج  ','1','templates','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

}


