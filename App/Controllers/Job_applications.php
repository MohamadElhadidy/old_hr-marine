<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class job_applications extends Authenticated
{
    public function newAction()
{
    $user = User::getPermission();
    $auth = Auth::getUser();
    if(strpos($user->ja , '3')){
        employess::insertNotificationsAdmin($auth->id,'تم الدخول على طلب التحاق','1','job_applications','1');
        View::renderTemplate('job_applications/new.html');
    }else{
        employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على طلب التحاق','1','job_applications','1');
        flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
        View::renderTemplate('Dashboard/index.php');
    }
}

public function saveApplicationAction()
{
    $user = User::getPermission();
    $auth = Auth::getUser();
    if(strpos($user->ja , '3')){
    $data = new employess($_POST);

    $image = upload_file::upload($_FILES['personal_photo'], 'job_applications/');

    if ($image) {

        if ($data->saveApplication($image)) {

            flash::addMessage("'تم عمل طلب التحاق'", flash::SUCCESS);
            $this->redirect('job_applications/new');
        }

    }
    else{
        View::renderTemplate('job_applications/new.html');
    }
    }else{
        employess::insertNotificationsAdmin($auth->id,'تم رفض حفظ  طلب التحاق','1','job_applications','1');
        flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
        View::renderTemplate('Dashboard/index.php');
    }
}

    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ja , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم الدخول  على طلبات الإلتحاق','1','job_applications','1');
            View::renderTemplate('job_applications/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  طلبات الإلتحاق','1','job_applications','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function deleteJobApplicationAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ja , '5')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?', $url);

            if ($data->deleteJobApplication($param[1])) {

                flash::addMessage("'تم حذف طلب الالتحاق بنجاح  '", flash::FAIL);
                $this->redirect('job_applications/report');
            }

        } else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض   حذف  طلب التحاق','1','job_applications','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ja , '6')){
         $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);
        $data =employess::findById($param[1],'job_application');

        if ($data) {
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على    طلب التحاق   ل'.$data->name,'1','job_applications','1');
            $residence_governorate  = employess::findByIdNoCom($data->residence_governorate ,'governorates');
            $residence_city   = employess::findByIdNoCom($data->residence_city  ,'cities');
            $place_of_birth_governorate   = employess::findByIdNoCom($data->place_of_birth_governorate  ,'governorates');
            $place_of_birth_city   = employess::findByIdNoCom($data->place_of_birth_city  ,'cities');
            $army_status   = employess::findByIdNoCom($data->army_status  ,'army_status');
            $marital_status   = employess::findByIdNoCom($data->marital_status  ,'marital_status');
            $qualification_type    = employess::findByIdNoCom($data->qualification_type   ,'qualification_type');

            $data->residence_governorate = $residence_governorate->governorate_name;
            $data->residence_city = $residence_city->city_name;
            $data->place_of_birth_governorate = $place_of_birth_governorate->governorate_name;
            $data->place_of_birth_city = $place_of_birth_city->city_name;
            $data->army_status = $army_status->name;
            $data->marital_status = $marital_status->name;
            $data->qualification_type = $qualification_type->name;

            View::renderTemplate('job_applications/view.html',[
                "data"=> $data
            ]);
        }
        } else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على    طلب التحاق   ','1','job_applications','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }

    }

    public  function getJobApplicationAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ja , '4')){
        $url = Auth::url();
        $param = explode('?', $url);

        $job_application= employess::findById($param[1], 'job_application');
        employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   تعديل طلب التحاق   ل'. $job_application->name,'1','job_applications','1');
            view::renderTemplate('job_applications/edit.html', [
            'job_application' => $job_application
        ]);
        } else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   تعديل طلب التحاق   ل','1','job_applications','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function EditJobApplicationAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ja , '4')){
        $data = new employess($_POST);
        $file = null;

        if ($_FILES["personal_photo"]["error"] == 4)
        {
            $file = null;
        }
        else{
        $file = upload_file::upload($_FILES['personal_photo'], 'job_applications/');
        }

        if ($data->editJobApplication($file)) {

            flash::addMessage("'تم تعديل الطلب بنجاح  '", flash::SUCCESS);
            $this->redirect('job_applications/report');
        }
        } else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض    تعديل طلب التحاق   ','1','job_applications','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function okJobApplicationAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ja , '3')){

            $data = new employess($_POST);
            $url = Auth::url();
            $param = explode('?', $url);

            $application=  employess::findById($param[1],'job_application');
            $id = $data->okJobApplication($param[1],$application->identification_id);
            if ($id) {
                $path = upload_file::mkDir($id);
                if ($path) {
                    $ext = pathinfo($application->personal_photo, PATHINFO_EXTENSION);
                    $copy= "../public/files/".$path."personal_photo.".$ext;
                     copy($application->personal_photo, $copy);
                    flash::addMessage("'تم الموافقة على  الطلب بنجاح  '", flash::SUCCESS);
                    $this->redirect('job_applications/report');
                    }

            }
        } else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض    الموافقة على طلب التحاق   ','1','job_applications','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }


}
