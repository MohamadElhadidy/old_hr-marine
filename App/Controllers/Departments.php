<?php


namespace App\Controllers;
use App\flash;
use App\Models\employess;
use App\Models\User;
use \Core\View;
use App\Auth;
use function GuzzleHttp\Promise\queue;


class departments extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->de , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   إضافة   إدارة  ','1','departments','1');
            View::renderTemplate('departments/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض الدخول على   إضافة   إدارة  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function saveDepartmentAction()
    {

        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->de , '3')){

        $data = new employess($_POST);

            if ($data->saveDepartment()) {

                flash::addMessage("'تم إضافة الإدارة بنجاح  '", flash::SUCCESS);
                $this->redirect('departments/new');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض    إضافة   إدارة  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function editDepartmentAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->de , '4')){
            $data = new employess($_POST);

        if ($data->editDepartment()) {

            flash::addMessage("'تم تعديل الإدارة بنجاح  '", flash::SUCCESS);
            $this->redirect('departments/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض    تعديل   إدارة  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function viewAction()
    {
        $user = User::getPermission();
        $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);
        $data =employess::fetchNotAllById($param[1],'department','data');
        $department =employess::findById($param[1],'departments');

        $auth = Auth::getUser();
        if(strpos($user->de , '6')){

            if ($data) {
            foreach ($data as &$row){
                $job = employess::findById($row->job,'jobs');
                $work_place = employess::findById($row->work_place,'work_places');
               if($job) $row->job = $job->name;
               if($work_place) $row->work_place = $work_place->name;
            }

            $manager  = employess::findById($department->manager ,'data');

            if($manager){
                $department->manager  = $manager->name;
            }
                employess::insertNotificationsAdmin($auth->id,'تم  الدخول   تقرير الموظفيين    لإدارة  '.$department->name,'1','departments','1');
                View::renderTemplate('departments/view.html',[
                "data"=> $data,
                "department" =>$department
            ]);

        }
        else{
            flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
            $this->redirect('departments/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول   تقرير الموظفيين    لإدارة  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->de , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول   تقرير     الإدارات  ','1','departments','1');
            View::renderTemplate('departments/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول   تقرير     الإدارات  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function deleteDepartmentAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->de , '5')){
        $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);

        if ($data->deleteDepartment($param[1])) {

            flash::addMessage("'تم حذف الإدارة بنجاح  '", flash::FAIL);
            $this->redirect('departments/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض    حذف     إدارة  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getDepartmentAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->de , '4')){
        $url = Auth::url();
        $param = explode('?',$url);

        $department = employess::findById($param[1],'departments');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول   على تعديل     إدارة  '.$department->name,'1','departments','1');

            view::renderTemplate('departments/edit.html',[
            'department' =>$department
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول   على تعديل     إدارة  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function managerAction()
    {
        $user = Auth::getUser();
        if($user->auth == '4'){
            $departments = employess::fetchAllByIdNoCom($user->id,'user_id','department_permission');
            if ($departments) {
                $i = 0;
                $arr =[];
                foreach ($departments as &$row) {
                    $arr[$i] = $row->department_id;
                $i++;
                }
                $data = employess::fetchAllMultiple('data','department',$arr);
                employess::insertNotificationsAdmin($user->id,'تم  الدخول   على      تقرير مسئول الإدارات  ','1','departments','1');

                View::renderTemplate('departments/manager.html',[
                    "data"=>$data
                ]);

            }else{
                View::renderTemplate('departments/manager.html');
            }
        }else{
            employess::insertNotificationsAdmin($user->id,'تم رفض الدخول   على      تقرير مسئول الإدارات  ','1','departments','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }



}