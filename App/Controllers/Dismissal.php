<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class Dismissal extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  إخلاء طرف ','1','Dismissal','1');
            View::renderTemplate('Dismissal/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  إخلاء طرف ','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function saveDismissalAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '3')){
        $data = new employess($_POST);

        $path = "employees/".$data->employee."/";

        $file = upload_file::upload($_FILES['file'], $path);


        if ($file) {

            if ($data->saveDismissal($file)) {

                flash::addMessage("'تم  إخلاء طرف موظف  '", flash::SUCCESS);
                $this->redirect('Dismissal/new');
            }

        }
        else{
            flash::addMessage("'يرجى إعادة  إخلاء الموظف  '", flash::FAIL);
            $this->redirect('Dismissal/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض    إخلاء طرف ','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '2')){
        $employee= employess::fetchAllById('1','status','data');
        
        foreach($employee as &$row){
           
           if($row->department){
              $department= employess::findById($row->department,'departments');
              $row->department =$department->name;
           }
              if($row->job){
                $job= employess::findById($row->job,'jobs');
                $row->job =$job->name;
              }
             
        }
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على تقرير المخلي طرفهم      ','1','Dismissal','1');
            view::renderTemplate('Dismissal/report.html', [
            'data' => $employee
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على تقرير المخلي طرفهم      ','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function editDismissalAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '4')){
            $data = new employess($_POST);
            $file = null;

            if ($_FILES["file"]["error"] == 4)
            {
                $file = null;
            }
            else{
                $employee = employess::findById($_POST["id"],'data');
                $path ='employees/'.$employee->id.'/';
                $file = upload_file::upload($_FILES['file'], $path);
            }

            if ($data->editDismissal($file)) {

                flash::addMessage("'تم تعديل اخلاء الطلب بنجاح  '", flash::SUCCESS);
                $this->redirect('Dismissal/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض تعديل    إخلاء طرف      ','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getDismissalAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '4')){
            $url = Auth::url();
            $param = explode('?', $url);

            $dismissal = employess::findById($param[1], 'data');
            employess::insertNotificationsAdmin($auth->id,'تم الدخول عل  تعديل    إخلاء طرف      ل'.$dismissal->name,'1','Dismissal','1');
            view::renderTemplate('Dismissal/edit.html', [
                'data' => $dismissal
            ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض  الدخول على تعديل    إخلاء طرف     ','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getFilesAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '6')){
            $url = Auth::url();
            $param = explode('?', $url);

            $dismissal = employess::findById($param[1], 'data');
            employess::insertNotificationsAdmin($auth->id,'تم الدخول عل  ملفات     إخلاء طرف      ل'.$dismissal->name,'1','Dismissal','1');
            view::renderTemplate('Dismissal/files.html', [
                'data' => $dismissal
            ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض  الدخول على ملفات    إخلاء طرف     ','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function returnAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->di , '3')){
            $data = new employess();
            $url = Auth::url();
            $param = explode('?',$url);

            if ($data->return($param[1])) {

                flash::addMessage("'تم إعادة توظيف موظف  بنجاح  '", flash::FAIL);
                $this->redirect('Dismissal/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض  إعادة موظف','1','Dismissal','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

}