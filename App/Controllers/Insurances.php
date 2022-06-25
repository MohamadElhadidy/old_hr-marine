<?php


namespace App\Controllers;
use App\Auth;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;
use App\flash;


class insurances extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ins , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   إضافة     تأمين','1','insurances','1');
            View::renderTemplate('insurances/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   إضافة     تأمين','1','insurances','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function saveInsuranceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ins , '3')){
        $data = new employess($_POST);

        $path = "employees/".$data->employee."/";

        $file = upload_file::upload($_FILES['file'], $path);


        if ($file) {

            if ($data->saveInsurance($file)) {

                flash::addMessage("'تم  إضافة تأمين '", flash::SUCCESS);
                $this->redirect('insurances/new');
            }

        }
        else{
            flash::addMessage("'يرجى إعادة  إضافة التأمين '", flash::FAIL);
            $this->redirect('insurances/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض     إضافة     تأمين','1','insurances','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ins , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تقرير التأمينات  ','1','insurances','1');
            View::renderTemplate('insurances/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تقرير التأمينات ','1','insurances','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ins , '6')){
        $url = Auth::url();
        $param = explode('?',$url);
        $data =employess::fetchAllById($param[1],'employee','insurances');
        $employee =employess::findById($param[1],'data');

        if ($data) {
            foreach ($data as &$row){
                $type = employess::findById($row->type,'insurances_type');
                $row->type = $type->name;
            }
            $department = employess::findById($employee->department,'departments');
            $job = employess::findById($employee->job,'jobs');
            $work_place = employess::findById($employee->work_place,'work_places');
            if($department)$employee->department = $department->name;
            if($job)$employee->job = $job->name;
            if($work_place)$employee->work_place = $work_place->name;
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على سجل تأمين ل'.$employee->name,'1','insurances','1');

            View::renderTemplate('insurances/view.html',[
                "data"=> $data,
                "employee" =>$employee
            ]);
        }
        else{
            flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
            $this->redirect('insurances/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على سجل تأمين ','1','insurances','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function editInsuranceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ins , '4')){
        $data = new employess($_POST);
        $file = null;

        if ($_FILES["file"]["error"] == 4)
        {
            $file = null;
        }
        else{
            $insurance = employess::findById($_POST["id"],'insurances');
            $employee = employess::findById($insurance->employee,'data');
            $path ='employees/'.$employee->id.'/';
            $file = upload_file::upload($_FILES['file'], $path);
        }

        if ($data->editInsurance($file)) {

            flash::addMessage("'تم تعديل التأمين بنجاح  '", flash::SUCCESS);
            $this->redirect('insurances/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض تعديل   سجل تأمين ','1','insurances','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function deleteInsuranceAction()
{
    $user = User::getPermission();
    $auth = Auth::getUser();
    if(strpos($user->ins , '5')){
    $data = new employess();
    $url = Auth::url();
    $param = explode('?',$url);

    if ($data->deleteInsurance($param[1])) {

        flash::addMessage("'تم حذف التأمين بنجاح  '", flash::FAIL);
        $this->redirect('insurances/report');
    }
    }else{
        employess::insertNotificationsAdmin($auth->id,'تم رفض  حذف سجل تأمين ','1','insurances','1');
        flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
        View::renderTemplate('Dashboard/index.php');
    }
}
    public  function getInsuranceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ins , '4')){
        $url = Auth::url();
        $param = explode('?', $url);

        $insurance = employess::findById($param[1], 'insurances');
            $employee = employess::findById($param[1], 'insurances');
            employess::insertNotificationsAdmin($auth->id,'تم  االدخول تعديل سجل تأمين ل'.$employee->name,'1','insurances','1');
            view::renderTemplate('insurances/edit.html', [
            'insurance' => $insurance
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض االدخول تعديل سجل تأمين ','1','insurances','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

}


