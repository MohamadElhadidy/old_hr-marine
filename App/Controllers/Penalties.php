<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class penalties extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '3')){
            employess::insertNotificationsAdmin($auth->id,'  تم  الدخول على إضافة  جزاء ','1','penalties','1');
            View::renderTemplate('penalties/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'  تم رفض الدخول على إضافة  جزاء ','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function savePenaltyAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '3')){
        $data = new employess($_POST);

        $path = "employees/".$data->employee."/";

        $file = upload_file::upload($_FILES['file'], $path);


        if ($file) {

            if ($data->savePenalty($file)) {

                flash::addMessage("'تم  إضافة جزاء '", flash::SUCCESS);
                $this->redirect('penalties/new');
            }

        }
        else{
            flash::addMessage("'يرجى إعادة  إضافة الجزاء '", flash::FAIL);
            $this->redirect('penalties/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'  تم  رفض   إضافة جزاء ','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '2')){
            employess::insertNotificationsAdmin($auth->id,'  تم  الدخول على تقرير الحزاءات ','1','penalties','1');
            View::renderTemplate('penalties/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'  تم رفض الدخول على تقرير الحزاءات  ','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '6')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?', $url);
            $data = employess::fetchAllById($param[1], 'employee', 'penalties');
            $employee = employess::findById($param[1], 'data');

            if ($data) {
                foreach ($data as &$row) {
                    $type = employess::findById($row->type, 'penalties_type');
                    $row->type = $type->name;
                }
                $department = employess::findById($employee->department, 'departments');
                $job = employess::findById($employee->job, 'jobs');
                $work_place = employess::findById($employee->work_place, 'work_places');
                if($department)$employee->department = $department->name;
                if($job)$employee->job = $job->name;
                if($work_place)$employee->work_place = $work_place->name;
                employess::insertNotificationsAdmin($auth->id,'  تم  الدخول على سجل جزاء ل'.$employee->name,'1','penalties','1');

                View::renderTemplate('penalties/view.html', [
                    "data" => $data,
                    "employee" => $employee
                ]);
            } else {
                flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
                $this->redirect('penalties/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على سجل جزاء','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
                View::renderTemplate('Dashboard/index.php');
            }
    }
    public function editPenaltyAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '4')){
        $data = new employess($_POST);
        $file = null;

        if ($_FILES["file"]["error"] == 4)
        {
            $file = null;
        }
        else{
            $penalty = employess::findById($_POST["id"],'penalties');
            $employee = employess::findById($penalty->employee,'data');
            $path ='employees/'.$employee->id.'/';
            $file = upload_file::upload($_FILES['file'], $path);
        }

        if ($data->editPenalty($file)) {
            flash::addMessage("'تم تعديل الجزاء بنجاح  '", flash::SUCCESS);
            $this->redirect('penalties/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض تعديل جزاء','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function deletePenaltyAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '5')){
        $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);

        if ($data->deletePenalty($param[1])) {

            flash::addMessage("'تم حذف الجزاء بنجاح  '", flash::FAIL);
            $this->redirect('penalties/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض حذف جزاء','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getPenaltyAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->pe , '4')){
        $url = Auth::url();
        $param = explode('?', $url);

        $penalty = employess::findById($param[1], 'penalties');
            $employee = employess::findById($penalty->employee, 'data');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول  على تعديل جزاء ل'.$employee->name,'1','penalties','1');
            view::renderTemplate('penalties/edit.html', [
            'penalty' => $penalty
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول  على تعديل جزاء ','1','penalties','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
}




