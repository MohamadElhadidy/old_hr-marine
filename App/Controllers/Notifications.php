<?php


namespace App\Controllers;
use App\Auth;
use App\Models\User;
use \Core\View;
use App\Models\employess;


class notifications extends Authenticated
{
    public  function notificationsAction()
    {
        $view = new employess($_POST);
        $data = $view->notifications();
        header('Content_Type: application/json');
        if($data == null) {
            $this->redirect('Dashboard/index');
        }else{
            echo json_encode($data);
        }
    }
      
    public  function onlineAction()
    {
        $view = new User($_POST);
        $view->online();
    }

    public  function indexAction()
    {
        $user = Auth::getUser();
        $notification = employess::getNotifications();
     
        employess::insertNotificationsAdmin($user->id,'  تم  الدخول على   الإشعارات ','1','notifications','1');
        View::renderTemplate('notifications/index.html');

    }
    public  function newAction()
    {
        $this->redirect('notifications/index');
    }

    public  function reportAction()
    {
        $this->redirect('notifications/index');

    }
    

}