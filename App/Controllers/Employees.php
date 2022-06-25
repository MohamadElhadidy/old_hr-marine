<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;


class employees extends Authenticated
{

    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   إضافة ملف موظف   ','1','employees','1');
            View::renderTemplate('employees/new.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
      public function moveAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على   إضافة ملف موظف   ','1','employees','1');
            View::renderTemplate('employees/move.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
        public function moveDataAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '3')){
            $data = new employess($_POST);

            if ( $data->moveData()) {

                    flash::addMessage("'تم إضافة موظف'", flash::SUCCESS);
                    $this->redirect('employees/new');
                }
                 else {
            employess::insertNotificationsAdmin($auth->id,'تم  رفص   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'يرجى المحاولة مرة أخرى'", flash::FAIL);
                View::renderTemplate('Dashboard/index.php');
            }
          
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم  رفص   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
                View::renderTemplate('Dashboard/index.php');
            }

    }
    public function saveDataAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '3')){
            $data = new employess($_POST);
            $id = $data->saveData();

            if ($id) {
                $path = upload_file::mkDir($id);

                if ($path) {
                    $files_name = array_keys($_FILES);

                    for ($i = 0; $i < count($files_name); $i++) {
                        $file = upload_file::upload($_FILES[$files_name[$i]], $path);

                        $data->saveFiles($files_name[$i], $file, $id);
                    }

                    flash::addMessage("'تم إضافة موظف'", flash::SUCCESS);
                    $this->redirect('employees/new');
                }
                 else {
            employess::insertNotificationsAdmin($auth->id,'تم  رفص   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'يرجى المحاولة مرة أخرى'", flash::FAIL);
                View::renderTemplate('Dashboard/index.php');
            }
            }
            else {
            employess::insertNotificationsAdmin($auth->id,'تم  رفص   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'يرجى المحاولة مرة أخرى'", flash::FAIL);
                View::renderTemplate('Dashboard/index.php');
            }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم  رفص   إضافة ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
                View::renderTemplate('Dashboard/index.php');
            }

    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '6')){
        $url = Auth::url();
        $param = explode('?',$url);
        $data =employess::findById($param[1],'data');

        if ($data) {
            $department = employess::findById($data->department,'departments');
            $job = employess::findById($data->job,'jobs');
            $work_place = employess::findById($data->work_place,'work_places');
            $residence_governorate  = employess::findByIdNoCom($data->residence_governorate ,'governorates');
            $residence_city   = employess::findByIdNoCom($data->residence_city  ,'cities');
            $place_of_birth_governorate   = employess::findByIdNoCom($data->place_of_birth_governorate  ,'governorates');
            $place_of_birth_city   = employess::findByIdNoCom($data->place_of_birth_city  ,'cities');
            $army_status   = employess::findByIdNoCom($data->army_status  ,'army_status');
            $marital_status   = employess::findByIdNoCom($data->marital_status  ,'marital_status');
            $qualification_type    = employess::findByIdNoCom($data->qualification_type   ,'qualification_type');
            
            if($department)$data->department = $department->name;
            if($job)$data->job = $job->name;
            if($work_place)$data->work_place = $work_place->name;

             if($data->residence_governorate) $data->residence_governorate = $residence_governorate->governorate_name;
            if($data->residence_city)$data->residence_city = $residence_city->city_name;
            if($data->place_of_birth_governorate)$data->place_of_birth_governorate = $place_of_birth_governorate->governorate_name;
            if($data->place_of_birth_city)$data->place_of_birth_city = $place_of_birth_city->city_name;
            if($data->army_status)$data->army_status = $army_status->name;
            if($data->marital_status)$data->marital_status = $marital_status->name;
            if($data->qualification_type)$data->qualification_type = $qualification_type->name;

            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  ملف موظف   ل'.$data->name,'1','employees','1');

            View::renderTemplate('employees/view.html',[
                "data"=> $data
            ]);
        }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');

        }
    }

    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تقرير  الموظفيين   ','1','employees','1');
            View::renderTemplate('employees/report.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تقرير  الموظفيين   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
     public function armyReportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تقرير  المجندين   ','1','employees','1');
            View::renderTemplate('employees/armyReport.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تقرير  المجندين   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }


 public function pensionReportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تقرير  المعاشات   ','1','employees','1');
            View::renderTemplate('employees/pensionReport.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تقرير  المعاشات   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function attachmentsAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تقرير  المرفقات   ','1','employees','1');
            View::renderTemplate('employees/attachments.html');
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تقرير  المرفقات   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public  function getEmployeeAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '4')){
        $url = Auth::url();
        $param = explode('?', $url);

        $employee= employess::findById($param[1], 'data');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على  تعديل  ملف موظف   ل'.$employee->name,'1','employees','1');
            view::renderTemplate('employees/edit.html', [
            'employee' => $employee
        ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على  تعديل  ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public  function getFilesAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '6')){
            $url = Auth::url();
            $param = explode('?', $url);

            $employee= employess::findById($param[1], 'data');
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على    ملفات موظف   ل'.$employee->name,'1','employees','1');
            view::renderTemplate('employees/files.html', [
                'data' => $employee
            ]);
        }else{
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على    ملفات موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function editDataAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->em , '4')){
            if($_POST){
            $id =$_POST['id'];
            $data = new employess($_POST);
            $file = null;
            $files_name =array_keys($_FILES);

            $path= "employees/".$id."/";

             for ($i = 0; $i < count($files_name); $i++) {
                  if ($_FILES[$files_name[$i]]["error"] == 4)
                        {
                            $file = null;
                        }
                        else{
                            $file = upload_file::upload($_FILES[$files_name[$i]], $path);
                            $data->saveFiles($files_name[$i], $file, $data->id);
                        }
             }
            if ($data->editData()) {

                flash::addMessage("'تم تعديل ملف موظف بنجاح  '", flash::SUCCESS);
                $this->redirect('employees/report');
            }
        
           
        }else {
            flash::addMessage("'يوجد خطأ في البيانات يرجى المحاولة مرة أخرى'", flash::FAIL);
            View::renderTemplate('Dashboard/index.php');
        }
    }
        else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض تعديل     ملف موظف   ','1','employees','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }


}


