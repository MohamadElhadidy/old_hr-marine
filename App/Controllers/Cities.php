<?php


namespace App\Controllers;
use \Core\View;
use App\Models\employess;

class cities extends Authenticated
{
    public  function getAction()
    {
        $id = new employess($_POST);
        $data = $id->getCities();
        header('Content_Type: application/json');
        echo json_encode($data);
    }
}