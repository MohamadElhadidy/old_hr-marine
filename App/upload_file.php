<?php


namespace App;
use App\token;


class upload_file
{
    public static function upload($file,$tar){
        if($file["type"] != '') {
            $_SupportedFormats = ['image/png', 'image/jpeg', 'image/jpg', 'application/pdf',
                'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
            if (in_array($file["type"], $_SupportedFormats)) {

                $s = round(microtime(true));
                $imageName = $file["name"];
                $target = "../public/files/" . $tar;
                $imageTarget = $target . $imageName;
                $tempimageName = $file["tmp_name"];
                $temp = explode(".", $file["name"]);
                $newfilename = $s . '.' . end($temp);
                $result = move_uploaded_file($tempimageName, $imageTarget . $newfilename);
                return $imageTarget . $newfilename;
            } else {
                flash::addMessage("'صيغة الملف غير مدعومة'", flash::FAIL);

                return false;
            }
        }
        else{
            return '_';
        }
    }
    public static function mkDir($name){
            $folderName ="../public/files/employees/".$name;
            if (file_exists($folderName)) {
                flash::addMessage("' الملف  موجود'",flash::FAIL);
                return false;

              }
        else{
            mkdir($folderName, 0777, true);
            return "employees/".$name.'/';
        }
    }



}