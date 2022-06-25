<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;

class holidays extends Authenticated
{
    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على إضافة     أجازة  ','1','holidays','1');
            View::renderTemplate('holidays/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على إضافة    أجازة  ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function saveHolidayAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '3')){
        $data = new employess($_POST);
         $file = null;

        if ($_FILES["file"]["error"] == 4)
        {
            $file = null;
        }
        else{
          $path = "employees/".$data->employee."/";
            $file = upload_file::upload($_FILES['file'], $path);

        }
        if ($file) {
            if ($data->saveHoliday($file)) {

                flash::addMessage("'تم  إضافة أجازة '", flash::SUCCESS);
                $this->redirect('holidays/new');
            }
        }
        else{
            flash::addMessage("'يرجى إعادة  إضافة الأجاوة '", flash::FAIL);
            $this->redirect('holidays/new');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض حفظ    أجازة  ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }


    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول  على  تقرير   الأجازات ','1','holidays','1');
            View::renderTemplate('holidays/report.html',[
                'month' => date('m', strtotime('0 month')),
                'year' => date('Y')
                ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول  على  تقرير   الأجازات  ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '6')){
         $post = new employess();
        $url = Auth::url();
        $param = explode('?',$url);
        
            if(isset($_POST['id']))
            {
            $id = $_POST['id'];
            }
            elseif(isset($param[1])){
             $id = $param[1];
            }
            else{
               $this->redirect('holidays/report');
            }
            
            $data = employess::fetchAllById($id,'employee','holidays');
              
            if(isset($_POST['from']) &&  isset($_POST['to'])) {
            if($_POST['from']!='' &&  $_POST['to'] !=''){
            $data = $post->getholidayspost($id,$_POST['from'],$_POST['to']);
            }
            else{
            $data = employess::fetchAllById($id,'employee','holidays');
            }
            }
        
        
            $employee =employess::findById($id,'data');

        if ($data) {
            foreach ($data as &$row){
                $type = employess::findById($row->type,'holidays_type');
                $row->type = $type->name;
            }
                $department = employess::findById($employee->department,'departments');
                $job = employess::findById($employee->job,'jobs');
                $work_place = employess::findById($employee->work_place,'work_places');
            if($department)$employee->department = $department->name;
            if($job)$employee->job = $job->name;
            if($work_place)$employee->work_place = $work_place->name;

            employess::insertNotificationsAdmin($auth->id,'تم  الدخول  على  سجل   أجازة    ل'.$employee->name,'1','holidays','1');

            View::renderTemplate('holidays/view.html',[
                "data"=> $data,
                "employee" =>$employee
            ]);
        }
        else{
            flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
            $this->redirect('holidays/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  سجل   أجازة   ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function deleteHolidayAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '5')){
        $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);

        if ($data->deleteHoliday($param[1])) {

            flash::addMessage("'تم حذف الأجازة بنجاح  '", flash::FAIL);
            $this->redirect('holidays/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض حذف   أجازة   ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function editHolidayAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '4')){
        $data = new employess($_POST);
        $file = null;

        if ($_FILES["file"]["error"] == 4)
        {
            $file = null;
        }
        else{
            $holiday = employess::findById($_POST["id"],'holidays');
            $employee = employess::findById($holiday->employee,'data');
            $path ='employees/'.$employee->id.'/';
            $file = upload_file::upload($_FILES['file'], $path);
        }

        if ($data->editHoliday($file)) {

            flash::addMessage("'تم تعديل الأجازة بنجاح  '", flash::SUCCESS);
            $this->redirect('holidays/report');
        }
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض     تعديل  أجازة   ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getHolidayAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->ho , '4')){
        $url = Auth::url();
        $param = explode('?', $url);

        $holiday = employess::findById($param[1], 'holidays');
        $employee = employess::findById($holiday->employee, 'data');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   تعديل  أجازة   ل'.$employee->name,'1','holidays','1');
            view::renderTemplate('holidays/edit.html', [
            'holiday' => $holiday
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   تعديل  أجازة   ','1','holidays','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

}



