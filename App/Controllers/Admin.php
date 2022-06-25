<?php


namespace App\Controllers;

use App\flash;
use App\Models\employess;
use App\Models\User;
use App\upload_file;
use \Core\View;
use App\Auth;


class admin extends Authenticated
{
    public function reportAction()
    {
        $user = Auth::getUser();
        if( $user->id == '29'){
            View::renderTemplate('users/report.html');
        }else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Dashboard/index.php');
        }
    }
    public function signUpAction()
    {
        $user = Auth::getUser();
        if( $user->id == '29'){
            View::renderTemplate('Signup/new.html');
        }else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }
    }
     public function newAction()
    {
         $this->redirect('admin/signUp');

    }
    public  function getUserAction()
    {
        $user = Auth::getUser();
        if( $user->id == '29') {
            $url = Auth::url();
            $param = explode('?', $url);

            $data = employess::findByIdNoCom($param[1], 'users');


            view::renderTemplate('users/edit.html',[
                'user' => $data,
                'permission' =>  User::permission($param[1]),
                'department_permission' =>  User::department_permission($param[1])
            ]);
        }
        else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }

    }
    public  function editUserAction()
    {
        $user = Auth::getUser();

        if( $user->id == '29') {
            $data = new user($_POST);

            $image =upload_file::upload($_FILES['personal_photo'],'users/');

            $file = null;

            if ($_FILES["personal_photo"]["error"] == 4)
            {
                $file = null;
            }
            else{
                $file =upload_file::upload($_FILES['personal_photo'],'users/');
            }


            if ($data->edit($file)) {

                flash::addMessage("'تم تعديل الحساب بنجاح'", flash::SUCCESS);
                $this->redirect('admin/report');
            }

         else {

            View::renderTemplate('users/edit.html', [
                'user' => $user
            ]);
        }


        }
        else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }

    }
    public function deleteDepartmentAction()
    {
        $user = Auth::getUser();
        if( $user->id == '29') {
            $data = new User();
            $url = Auth::url();
            $param = explode('?', $url);

            if ($data->deleteDepartment($param[1])) {

                flash::addMessage("'تم تعديل الحساب بنجاح '", flash::SUCCESS);
                $this->redirect('admin/report');
            }
        }
        else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }

    }
    public function deleteUserAction()
    {

        $data = new User();
        $user = Auth::getUser();
        if( $user->id == '29') {
        $url = Auth::url();
        $param = explode('?',$url);

        if ($data->deleteUser($param[1])) {

            flash::addMessage("'تم تعديل الحساب بنجاح '", flash::SUCCESS);
            $this->redirect('admin/report');
        }
        }
        else{
            flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
            View::renderTemplate('Login/new');
        }

    }
    public  function onlineUsersAction()
    {
        $view = new User($_POST);
        $data = $view->onlineUser();
        header('Content_Type: application/json');
        if($data == null) {
            $this->redirect('Dashboard/index');
        }else{
            echo json_encode($data);
        }
    }




}