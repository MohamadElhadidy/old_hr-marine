<?php


namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use \Core\View;


class fingerprints extends Authenticated
{
      public function updateAction()
    {
                $this->redirect('fingerprints/report');
    }
        public function newAction()
    {
                $this->redirect('fingerprints/report');
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if (strpos($user->fp, '2')) {
           
                 
                    employess::insertNotificationsAdmin($auth->id, 'تم الدخول على تقرير البصمات   ' , '1','fingerprints','1');
                
            

            View::renderTemplate('fingerprints/report.html');
        }
        else{
            employess::insertNotificationsAdmin($auth->id, 'تم  رفض الدخول على تقرير البصمة   ' , '1','fingerprints','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if (strpos($user->fp, '6')) {
            $post = new employess();
            $url = Auth::url();
            $param = explode('?',$url);
           
            if(isset($_POST['id']))
            {
            $fingerprint = $_POST['id'];
            }
            elseif(isset($param[1])){
             $fingerprint = $param[1];
            }
            else{
               $this->redirect('fingerprints/report');
            }
            
              $data = $post->getfingerprint($fingerprint);
              
            if(isset($_POST['from']) &&  isset($_POST['to'])) {
            if($_POST['from']!='' &&  $_POST['to'] !=''){
            $data = $post->getfingerprintpost($fingerprint,$_POST['from'],$_POST['to']);
            }
            else{
                $data = $post->getfingerprint($fingerprint); 
            }
            }
    
            $employee =employess::findByColNoCom($fingerprint,'fingerprint','data');


            if ($employee) {
                $department = employess::findByColNoCom($employee->department,'id','departments');
                $job = employess::findByColNoCom($employee->job,'id','jobs');
                $work_place = employess::findByColNoCom($employee->work_place,'id','work_places');
                if($department)$employee->department = $department->name;
                if($job)$employee->job = $job->name;
                if($work_place)$employee->work_place = $work_place->name;

                foreach ($data as &$row){
                    $fingerprint_id = employess::findByIdNoCom($row->fingerprint_id ,'fingerprint_types');
                    $row->fingerprint_id = $fingerprint_id->name;
                    $timestamp = strtotime($row->date);
                    $day = date('D', $timestamp);
                    if($day == 'Thu') $day = 'الخميس';
                    if($day == 'Wed') $day = 'الأربعاء';
                    if($day == 'Tue') $day = 'الثلاثاء';
                    if($day == 'Mon') $day = 'الإثنين';
                    if($day == 'Sun') $day = 'الأحد';
                    if($day == 'Sat') $day = 'السبت';
                    if($day == 'Fri') $day = 'الجمعة';
                    $row->fingerprint_type = $day;
                     
                }
                employess::insertNotificationsAdmin($auth->id, 'تم  الدخول على تقرير البصمة   ل' . $employee->name, '1','fingerprints','1');

                View::renderTemplate('fingerprints/view.html',[
                    "data"=> $data,
                    "employee" =>$employee
                ]);
            }
            else{
                flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
                $this->redirect('fingerprints/report');
            }
        }else{
            employess::insertNotificationsAdmin($auth->id, ' رفض الدخول على تقرير البصمة لموظف', '1','fingerprints','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

}


