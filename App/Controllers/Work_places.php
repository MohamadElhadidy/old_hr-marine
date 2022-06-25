<?php

namespace App\Controllers;
use App\Auth;
use App\flash;
use App\Models\employess;
use App\Models\User;
use \Core\View;


class work_places extends Authenticated
{

    public function newAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '3')){
            employess::insertNotificationsAdmin($auth->id,'تم الدخول على إضافة موقع العمل     ','1','work_places','1');
            View::renderTemplate('work_places/new.html');
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض لدخول على  إضافة موقع العمل     ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function saveWorkPlaceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '3')){
        $data = new employess($_POST);

        if ($data->saveWorkPlace()) {

            flash::addMessage("'تم إضافة موقع العمل بنجاح  '", flash::SUCCESS);
            $this->redirect('work_places/new');
        }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض إضافة موقع العمل     ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function editWorkPlaceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '4')){
        $data = new employess($_POST);

        if ($data->editWorkPlaces()) {

            flash::addMessage("'تم تعديل موقع العمل بنجاح  '", flash::SUCCESS);
            $this->redirect('work_places/report');
        }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض    تعديل موقع العمل     ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function viewAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '6')){

        $url = Auth::url();
        $param = explode('?',$url);
        $data =employess::fetchAllById($param[1],'work_place','data');
        $work_place =employess::findById($param[1],'work_places');

        if ($data) {
            foreach ($data as &$row){
                $department= employess::findById($row->department,'departments');
                $job = employess::findById($row->job,'jobs');
                $row->department = $department->name;
                $row->job = $job->name;
            }
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على تقرير الموظفيين لمواقع العمل     '.$work_place->name,'1','work_places','1');

            View::renderTemplate('work_places/view.html',[
                "data"=> $data,
                "work_place" =>$work_place
            ]);
        }
        else{
            flash::addMessage("'لا يوجد بيانات '", flash::FAIL);
            $this->redirect('work_places/report');
        }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على تقرير الموظفيين لمواقع العمل     ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function reportAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '2')){
            employess::insertNotificationsAdmin($auth->id,'تم  الدخول على تقرير مواقع العمل     ','1','work_places','1');
            View::renderTemplate('work_places/report.html');
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على تقرير مواقع العمل    ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }

    public function deleteWorkPlaceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '5')){
        $data = new employess();
        $url = Auth::url();
        $param = explode('?',$url);

        if ($data->deleteWorkPlaces($param[1])) {

            flash::addMessage("'تم حذف موقع العمل بنجاح  '", flash::FAIL);
            $this->redirect('work_places/report');
        }
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض حذف موقع العمل     ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }

    }
    public  function getWorkPlaceAction()
    {
        $user = User::getPermission();
        $auth = Auth::getUser();
        if(strpos($user->wp , '4')){
        $url = Auth::url();
        $param = explode('?',$url);

        $work_place= employess::findById($param[1],'work_places');
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على تعديل موقع العمل     '.$work_place->name,'1','work_places','1');
            view::renderTemplate('work_places/edit.html',[
            'work_place' =>$work_place
        ]);
        }else {
            employess::insertNotificationsAdmin($auth->id,'تم رفض الدخول على تعديل موقع العمل     ','1','work_places','1');
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
}

