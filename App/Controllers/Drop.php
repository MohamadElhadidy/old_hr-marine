<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class Drop extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  إضافة  انقطاع عن العمل','1','drop','1');
            View::renderTemplate('Drop/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  إضافة  انقطاع عن العمل','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function saveDropAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '3')){
        $data = new employess($_POST);

        $path = "employees/".$data->employee."/";

        $file = upload_file::upload($_FILES['file'], $path);


        if ($file) {

            if ($data->saveDrop($file)) {

                flash::addMessage("'تم إضافة  إنقطاع عن العمل لموظف  '", flash::SUCCESS);
                $this->redirect('Drop/new');
            }

        }
        else{
            flash::addMessage("'يرجى إعادة  إنقطاع الموظف  '", flash::FAIL);
            $this->redirect('Drop/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض حفظ    انقطاع عن العمل','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

     public function cancelDropAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '3')){
                        $data = new employess();

        $url = Auth::url();
            $param = explode('?',$url);

            if ($data->cancelDrop($param[1])) {

                flash::addMessage("'تم  إرجاع موظف للعمل بعد إنقطاعة  '", flash::SUCCESS);
                $this->redirect('Drop/report');
            }

        
        else{
            flash::addMessage("'يرجى إعادة    المحاولة  '", flash::FAIL);
            $this->redirect('Drop/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض حفظ    انقطاع عن العمل','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم الدخول  على تقرير المنقطعين عن العمل','1','drop','1');
            View::renderTemplate('Drop/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول  على تقرير المنقطعين عن العمل','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '6')){
            $url = Auth::url();
            $param = explode('?',$url);
            $data =employess::fetchAllById($param[1],'employee','drops');
            $employee =employess::findById($param[1],'data');

            if ($data) {

                $department = employess::findById($employee->department,'departments');
                $job = employess::findById($employee->job,'jobs');
                $work_place = employess::findById($employee->work_place,'work_places');
                if($department)$employee->department = $department->name;
                if($job)$employee->job = $job->name;
                if($work_place)$employee->work_place = $work_place->name;

                employess::insertNotificationsAdmin($auth->id,'تم الدخول  على انقطاع عن العمل   ل'.$employee->name,'1','drop','1');

                View::renderTemplate('Drop/view.html',[
                    "data"=> $data,
                    "employee" =>$employee
                ]);
            }
            else{
                flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
                $this->redirect('holidays/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض   الدخول على   انقطاع عن العمل  لموظف ','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function deleteDropAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '5')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?',$url);

            if ($data->deleteDrop($param[1])) {

                flash::addMessage("'تم حذف انقطاع عن العمل بنجاح  '", flash::FAIL);
                $this->redirect('Drop/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض     حذف انقطاع عن العمل   ','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function editDropAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '4')){
            $data = new employess($_POST);
            $file = null;

            if ($_FILES["file"]["error"] == 4)
            {
                $file = null;
            }
            else{
                $drop = employess::findById($_POST["id"],'drops');
                $employee = employess::findById($drop->employee,'data');
                $path ='employees/'.$employee->id.'/';
                $file = upload_file::upload($_FILES['file'], $path);
            }

            if ($data->editDrop($file)) {

                flash::addMessage("'تم تعديل انقطاع عن العمل بنجاح  '", flash::SUCCESS);
                $this->redirect('Drop/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض     تعديل انقطاع عن العمل   ','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getDropAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->dr , '4')){
            $url = Auth::url();
            $param = explode('?', $url);

            $drop = employess::findById($param[1], 'drops');
            $data = employess::findById($param[1], 'data');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   تعديل انقطاع عن العمل   ل'. $data->name,'1','drop','1');
            view::renderTemplate('Drop/edit.html', [
                'drop' => $drop
            ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   تعديل انقطاع عن العمل ','1','drop','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

}