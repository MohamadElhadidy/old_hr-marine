<?php


namespace App\Controllers;
use App\flash;
use App\Models\employess;
use App\Models\User;
use \Core\View;
use App\Auth;


class jobs extends Authenticated
{

    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   إضافة وظيفة','1','jobs','1');
            View::renderTemplate('jobs/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   إضافة وظيفة','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }

    }
    public function saveJobAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '3')){
        $data = new employess($_POST);

        if ($data->saveJob()) {

            flash::addMessage("'تم إضافة الوظيفة بنجاح  '", flash::SUCCESS);
            $this->redirect('jobs/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض     إضافة وظيفة','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }

    }
    public function editJobAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '4')){
        $data = new employess($_POST);

        if ($data->editJob()) {

            flash::addMessage("'تم تعديل الوظيفة بنجاح  '", flash::SUCCESS);
            $this->redirect('jobs/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض     تعديل وظيفة','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '6')){
        $data = new employess();

        $url = Auth::url();
        $param = explode('?',$url);
        $data =employess::fetchAllById($param[1],'job','data');
        $job =employess::findById($param[1],'jobs');

        if ($data) {
            foreach ($data as &$row){
                $department= employess::findById($row->department,'departments');
                $work_place = employess::findById($row->work_place,'work_places');
                $row->department = $department->name;
                $row->work_place = $work_place->name;
            }
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول    تقرير الموظفيين لوظيفة'.$job->name,'1','jobs','1');

            View::renderTemplate('jobs/view.html',[
                "data"=> $data,
                "job" =>$job
            ]);
        }
        else{
            flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
            $this->redirect('jobs/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول رفض   تقرير الموظفيين لوظيفة','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول    تقرير  الوظائف','1','jobs','1');
            View::renderTemplate('jobs/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول    تقرير  الوظائف','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function deleteJobAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '5')){
        $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);

        if ($data->deleteJob($param[1])) {

            flash::addMessage("'تم حذف الوظيفة بنجاح  '", flash::FAIL);
            $this->redirect('jobs/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم  رفض  حذف الوظيفة    ','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public  function getJobAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->jo , '4')){

        $url = Auth::url();
        $param = explode('?',$url);

        $job= employess::findById($param[1],'jobs');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول  على تعديل وظيفة '.$job->name,'1','jobs','1');
            view::renderTemplate('jobs/edit.html',[
            'job' =>$job
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول  على تعديل وظيفة ','1','jobs','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }


}
