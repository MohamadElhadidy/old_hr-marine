<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class salaries extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '3')){
            if(employess::checkDate()) {
                employess::insertNotificationsAdmin($auth->id,'تم  الدخول على إضافة شهر رواتب جديد  ','1','salaries','1');
                View::renderTemplate('salaries/new.html');
            }else{
                employess::insertNotificationsAdmin($auth->id,' تم ادخال هذا الشهر من قبل ','1','salaries','1');
                flash::addMessage("'تم ادخال هذا الشهر من قبل'", flash::INFO);
                    View::renderTemplate('Dashboard/index.php');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على إضافة شهر رواتب جديد  ','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function saveSalariesAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '3')){
            $data = new employess($_POST);

                if ($data->saveSalaries()) {

                    flash::addMessage("'تم إضافة  شهر رواتب جديد  '", flash::SUCCESS);
                    $this->redirect('Dashboard/index');


            }
            else{
                flash::addMessage("'يرجى إضافة  شهر رواتب جديد   '", flash::FAIL);
                $this->redirect('salaries/new');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض  إضافة شهر رواتب ','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على      التقارير السابقة ','1','salaries','1');
            View::renderTemplate('salaries/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على    التقارير السابقة','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '6')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?',$url);
            $salaries = employess::fetchAllById($param[1],'date_id','salaries');
            $date = explode('-',$param[1]);
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على     شهر رواتب '.$param[1],'1','salaries','1');

            if ($salaries) {
                    View::renderTemplate('salaries/view.html', [
                        "salaries" => $salaries,
                        "month"=>$date[0],
                        "year"=>$date[1]
                    ]);
                }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تمرفض  الدخول على     شهر رواتب ','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');

        }
    }
    public function deleteSalaryAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '5')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?',$url);

            if ($data->deleteSalary($param[1])) {

                flash::addMessage("'تم حذف الشهر بنجاح  '", flash::FAIL);
                $this->redirect('salaries/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض   حذف  شهر رواتب ','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function getSalaryAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '4')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?',$url);

            $salary = employess::fetchAllById($param[1],'date_id','salaries');
            $data->updateSalary($salary,$param[1]);

            $date = explode('-',$param[1]);
            $salaries = employess::fetchAllById($param[1],'date_id','salaries');
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على   تعديل  شهر رواتب '.$salaries->date_id,'1','salaries','1');

            if ($salaries) {
                View::renderTemplate('salaries/edit.html', [
                    "salaries" => $salaries,
                    "month"=>$date[0],
                    "year"=>$date[1]
                ]);
            }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   تعديل  شهر رواتب ','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');

        }
    }
    public function editSalariesAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->sa , '4')){
            $data = new employess($_POST);

            if ($data->editSalaries()) {

                flash::addMessage("'تم تعديل  شهر رواتب   '", flash::SUCCESS);
                $this->redirect('salaries/report');
            }
            else{
                flash::addMessage("'يرجى تعديل  شهر رواتب    '", flash::FAIL);
                $this->redirect('salaries/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض   تعديل  شهر رواتب ','1','salaries','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }


}


