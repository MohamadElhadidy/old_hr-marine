<?php


namespace App\Models;
use App\Auth;
use App\Controllers\employees;
use App\flash;
use App\upload_file;
use DateTime;
use DateTimeZone;
use App\Mail;
use PDO;
use  App\token;
use Core\View;


class employess  extends \Core\Model
{
    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        }
        
    }

    public static function companies()
    {
        $conn = new PDO("mysql:host=localhost;dbname=hr", 'user', 'password');
        $conn->exec("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM companies  WHERE is_delete = 0 ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

           return $stmt->fetchAll();


        }
    }

    public static  function findById($id,$table)
    {

        $sql = "SELECT *  FROM `" . $table . "` where id = :id AND company =:company
         AND is_delete = 0 ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    public static  function findByIdNoCom($id,$table)
    {

        $sql = "SELECT *  FROM `" . $table . "` where id = :id  ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    public  static function fetchNotAllById($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col AND company =:company
         AND is_delete = 0 AND status = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
        public  static function fetchAllById($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col AND company =:company
         AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetchAll();
    }
    public  static function fetchAllByIdNoCom($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col 
         AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetchAll();
    }
    public  static function findByColNoCom($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col 
         AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    public  static function findByCol($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col 
         AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

        public  static function findByColWithCom($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col 
           AND company =:company ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }


    public  static function fetchAllMultiple($table,$col,$arr = [])
    {
        $arr =implode(',', array_map('intval', $arr));
        $sql = "SELECT *  FROM `" . $table . "`   WHERE  `" . $col . "` IN  ($arr)
         AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public  static function sum($sum,$table,$col,$val,$col2,$val2)
    {
        $sql = " SELECT SUM(`" . $sum . "`) as sum from `" . $table . "`
         WHERE  `" . $col . "` = :col AND  `" . $col2 . "` = :col2 AND company =:company
         AND is_delete = 0" ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':col2', $val2, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    public  static function count($count,$table,$col,$val)
    {

        $sql = "SELECT COUNT(`" . $count . "`) as count FROM `" . $table . "`  where  `" . $col . "` = :col
         AND company =:company AND is_delete = 0 ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    
  public  static function countTwo($count,$table,$col,$val,$col2,$val2)
    {

        $sql = "SELECT COUNT(`" . $count . "`) as count FROM `" . $table . "`  where  `" . $col . "` = :col AND  `" . $col2 . "` = :col2
         AND company =:company AND is_delete = 0 ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':col2', $val2, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    public function saveApplication($file)
    {

        date_default_timezone_set("Africa/Cairo");

            $sql ='INSERT INTO job_application
                (name, telephone,company, residence_governorate,residence_city,residence_street, place_of_birth_governorate,
                 place_of_birth_city,place_of_birth_street ,date_of_birth, identification_id, army_status,
                 marital_status ,qualification_type, graduation_date, qualification_name,
                 date_of_application,personal_photo )
                VALUES (:name, :telephone,:company, :residence_governorate,:residence_city,
                        :residence_street, :place_of_birth_governorate, :place_of_birth_city,:place_of_birth_street,
                        :date_of_birth, :identification_id, :army_status,:marital_status,
                        :qualification_type, :graduation_date, :qualification_name,:date_of_application,
                        :personal_photo)';

            $db = static::getDB();
            $stmt =$db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $this->telephone, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':residence_governorate', $this->residence_governorate, PDO::PARAM_STR);
        $stmt->bindValue(':residence_city', $this->residence_city, PDO::PARAM_STR);
        $stmt->bindValue(':residence_street', $this->residence_street, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_governorate', $this->place_of_birth_governorate, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_city', $this->place_of_birth_city, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_street', $this->place_of_birth_street, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_birth', $this->date_of_birth, PDO::PARAM_STR);
        $stmt->bindValue(':identification_id', $this->identification_id, PDO::PARAM_INT);
        $stmt->bindValue(':army_status', $this->army_status, PDO::PARAM_STR);
        $stmt->bindValue(':marital_status', $this->marital_status, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_type', $this->qualification_type, PDO::PARAM_STR);
        $stmt->bindValue(':graduation_date', $this->graduation_date, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_name', $this->qualification_name, PDO::PARAM_STR);
        $stmt->bindValue(':personal_photo', $file, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_application',date('Y-m-d H-i-s'), PDO::PARAM_STR);

        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم عمل طلب التحاق ل'.$this->name,'job_applications');
            return true;
    }else{
            return false;
        }

    }
    public function saveData()
    {
               $identification_id= employess::findByColWithCom($this->identification_id,'identification_id','data');
               
               
  if($identification_id){
    return false;
}else{
    if($this->graduation_date == '') $this->graduation_date=0;
        $sql ='INSERT INTO data
                (name, telephone,company, residence_governorate,residence_city,residence_street, place_of_birth_governorate,
                 place_of_birth_city,place_of_birth_street ,date_of_birth, identification_id, army_status,
                 marital_status ,qualification_type, graduation_date, qualification_name, fingerprint 
              ,department ,job ,work_place,date_of_hiring)
                VALUES (:name, :telephone,:company, :residence_governorate,:residence_city,
                        :residence_street, :place_of_birth_governorate, :place_of_birth_city,:place_of_birth_street,
                        :date_of_birth, :identification_id, :army_status,:marital_status,
                        :qualification_type, :graduation_date, :qualification_name, :fingerprint
                    ,:department ,:job ,:work_place,:date_of_hiring)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $this->telephone, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':residence_governorate', $this->residence_governorate, PDO::PARAM_STR);
        $stmt->bindValue(':residence_city', $this->residence_city, PDO::PARAM_STR);
        $stmt->bindValue(':residence_street', $this->residence_street, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_governorate', $this->place_of_birth_governorate, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_city', $this->place_of_birth_city, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_street', $this->place_of_birth_street, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_birth', $this->date_of_birth, PDO::PARAM_STR);
        $stmt->bindValue(':identification_id', $this->identification_id, PDO::PARAM_INT);
        $stmt->bindValue(':army_status', $this->army_status, PDO::PARAM_STR);
        $stmt->bindValue(':marital_status', $this->marital_status, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_type', $this->qualification_type, PDO::PARAM_STR);
        $stmt->bindValue(':graduation_date', $this->graduation_date, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_name', $this->qualification_name, PDO::PARAM_STR);
        $stmt->bindValue(':fingerprint', $this->fingerprint , PDO::PARAM_INT);
        $stmt->bindValue(':department', $this->department , PDO::PARAM_INT);
          $stmt->bindValue(':job', $this->job  , PDO::PARAM_INT);
          $stmt->bindValue(':work_place', $this->work_place , PDO::PARAM_INT);
          $stmt->bindValue(':date_of_hiring', $this->date_of_hiring, PDO::PARAM_STR);


        if ($stmt->execute()) {

            $sql = 'SELECT *  FROM data   where identification_id = :identification_id AND status = 0
        And company = :company';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':identification_id', $this->identification_id, PDO::PARAM_STR);
            $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            $data = $stmt->fetch();

            $user=Auth::getUser();

            if ($data) {
                    employess::insertNotifications($user->id, 'تم إضافة موظف   ' . $this->name,'employees');
                return $data->id;
            } else {
                return false;
            }
        }
}
    }
    public function editData()
    {


        $sql ='UPDATE  data
                 SET 
                 orderBy = :orderBy  ,
                 name = :name  ,
              telephone = :telephone  ,
               company = :company  ,
               residence_street = :residence_street  ,
              place_of_birth_street  = :place_of_birth_street  ,
            identification_id = :identification_id  , 
            army_status = :army_status  ,
             marital_status  = :marital_status ,
            qualification_type = :qualification_type,
            graduation_date = :graduation_date, 
            qualification_name = :qualification_name,
             fingerprint  = :fingerprint, 
            department  = :department, 
            job  = :job  , 
            work_place  = :work_place  ,
            job_status  = :job_status
          
              ';


        if ($this->date_of_birth != null) $sql .= " ,date_of_birth= :date_of_birth";
        if ($this->date_of_hiring != null) $sql .= " ,date_of_hiring= :date_of_hiring";
        if (isset($this->residence_governorate)) $sql .= " ,residence_governorate=".$this->residence_governorate;
        if (isset($this->residence_city)) $sql .= " ,residence_city=".$this->residence_city;
        if (isset($this->place_of_birth_governorate)) $sql .= " ,place_of_birth_governorate=".$this->place_of_birth_governorate;
        if (isset($this->place_of_birth_city)) $sql .= " ,place_of_birth_city=".$this->place_of_birth_city;


        $sql.='  where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':orderBy', $this->orderBy, PDO::PARAM_STR);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $this->telephone, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':residence_street', $this->residence_street, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_street', $this->place_of_birth_street, PDO::PARAM_STR);
        if ($this->date_of_birth != null) $stmt->bindValue(':date_of_birth', $this->date_of_birth, PDO::PARAM_STR);
        $stmt->bindValue(':identification_id', $this->identification_id, PDO::PARAM_INT);
        $stmt->bindValue(':army_status', $this->army_status, PDO::PARAM_STR);
        $stmt->bindValue(':marital_status', $this->marital_status, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_type', $this->qualification_type, PDO::PARAM_STR);
        $stmt->bindValue(':graduation_date', $this->graduation_date, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_name', $this->qualification_name, PDO::PARAM_STR);
        $stmt->bindValue(':fingerprint', $this->fingerprint, PDO::PARAM_STR);
        $stmt->bindValue(':department', $this->department , PDO::PARAM_STR);
        $stmt->bindValue(':job', $this->job , PDO::PARAM_STR);
        $stmt->bindValue(':work_place', $this->work_place , PDO::PARAM_STR);
        $stmt->bindValue(':job_status', $this->job_status , PDO::PARAM_STR);
        if ($this->date_of_hiring != null) $stmt->bindValue(':date_of_hiring', $this->date_of_hiring, PDO::PARAM_STR);




        $user=Auth::getUser();
        $employee = employess::FindByID($this->id, 'data');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل ملف موظف  ل   '.$employee->name,'employees');
            return true;
        }else{
            return false;
        }

    }
    public function saveFiles($name,$file,$id)
    {


            $sql = "UPDATE  data
                SET $name = '$file'
                WHERE id = '$id' ";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

          $stmt->execute();



    }





    public function saveDismissal($file)
    {


        $sql ='Update data 
             SET
            date_of_dismissal = :date_of_dismissal,
            dismissal_file =:dismissal_file,
            status = 1
            WHERE id = :employee ';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_dismissal', $this->date	, PDO::PARAM_STR);
        $stmt->bindValue(':dismissal_file', $file	, PDO::PARAM_STR);



        $user=Auth::getUser();

        $employee = self::findById($this->employee,'data');

        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم إخلاء طرف     '.$employee->name,'dismissal');
            return true;
        }else{
            return false;
        }

    }
    public function EditDismissal($file)
    {


        $sql ='Update data 
             SET
             name = :employee
            ';

        if ($file != null) $sql .= " ,dismissal_file='$file'";
        if ($this->date != null) $sql .= " ,date_of_dismissal='$this->date'";

        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);



        $user=Auth::getUser();

        $employee = self::findById($this->id,'data');

        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم تعديل إخلاء طرف     '.$employee->name,'dismissal');
            return true;
        }else{
            return false;
        }

    }
    public function return($id)
    {

        $sql ='UPDATE  data
               SET
               status = 0
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();
        $employee = employess::FindByID($id, 'data');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم إعادة توظيف موظف    '.$employee->name,'employees');
            return true;
        }else{
            return false;
        }

    }

    public function saveDrop($file)
    {


        $sql ='INSERT INTO drops
                (employee,company,date, file ,notes )
                VALUES (:employee,:company,
                        :date, :file,:notes	)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':file', $file	, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);


        $user=Auth::getUser();

        $employee = self::findById($this->employee,'data');

        if($stmt->execute()){

        $sql ='Update data
                Set drop_out = 1
                Where id= :employee';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);


       $stmt->execute();

            employess::insertNotifications($user->id,'تم إضافة انقطاع عمل    ل'.$employee->name,'drop');
            return true;
        }else{
            return false;
        }

    }

     public function cancelDrop($id)
    {
        $drop = self::findById($id,'drops');
        $sql ='Update drops
                Set is_delete = 1
                Where id= :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

       $stmt->execute();

    if($stmt->execute()){
        $user=Auth::getUser();
        $employee = self::findById($drop->employee,'data');

        $sql ='Update data
                Set drop_out = 0
                Where id= :employee';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $employee->id, PDO::PARAM_STR);


       $stmt->execute();

            employess::insertNotifications($user->id,'تم  إرجاع موظف للعمل بعد إنقطاعة'.$employee->name,'drop');
            return true;
        }else{
            return false;
        }

    }
    public function editDrop($file)
    {


        $sql ='UPDATE  drops
                 SET 
            notes = :notes
              ';

        if ($file != null) $sql .= " ,file='$file'";
        if ($this->date != null) $sql .= " ,date='$this->date'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);

        $user=Auth::getUser();
        $drop = self::findById($this->id,'drops');
        $employee = self::findById($drop->employee,'data');
        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل انقطاع عمل  لموظف  '.$employee->name,'drop');
            return true;
        }else{
            return false;
        }

    }



    public static  function getDrops()
    {
        $user = Auth::getUser();
        if ($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM drops  where  is_delete = 0  AND company=:company group by employee ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $employee = employess::findById($row->employee, 'data');
                        $year = employess::count('id', 'drops', 'employee', $row->employee);


                        $row->notes = $row->employee;
                        $row->employee = $employee->name;
                        $row->is_delete = $year->count;

                    }
                }

                return $data;


            }
        }
    }



    public function deleteDrop($id)
    {

        $sql ='UPDATE  drops
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();

        $drop = employess::FindByID($id, 'drops');
        $employee = employess::FindByID($drop->employee, 'data');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف انقطاع عن العمل لموظف   '.$employee->name,'drop');
            return true;
        }else{
            return false;
        }

    }

    public function saveTemplate($file)
    {


        $sql ='INSERT INTO templates
                (name, file,notes, company )
                VALUES (:name, :file,:notes	,:company)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':file', $file	, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);


        $user=Auth::getUser();

        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم إضافة نموذج   '.$this->name,'templates');
            return true;
        }else{
            return false;
        }

    }
    public static  function getTemplates()
    {
        $user = Auth::getUser();
        if ($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM templates  where  is_delete = 0  AND company=:company ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

                return $stmt->fetchAll();


            }
        }
    }
    public function editTemplate($file)
    {


        $sql ='UPDATE  templates
                 SET 
            name = :name,
            notes = :notes
              ';

        if ($file != null) $sql .= " ,file='$file'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);

        $user=Auth::getUser();
        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل نموذج     '.$this->name,'templates');
            return true;
        }else{
            return false;
        }

    }

    public function deleteTemplate($id)
    {

        $sql ='UPDATE  templates
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();
        $template= employess::FindByID($id, 'templates');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف نموذج    '.$template->name,'templates');
            return true;
        }else{
            return false;
        }

    }


    public function saveDepartment()
    {
        if($this->manager ==''){
            $this->manager = null;
        }


        $sql ='INSERT INTO departments
                (name,company, manager, color,tasks)
                VALUES (:name,:company, :manager, :color,:tasks)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':manager', $this->manager, PDO::PARAM_INT);
        $stmt->bindValue(':color', $this->color, PDO::PARAM_STR);
        $stmt->bindValue(':tasks', $this->tasks, PDO::PARAM_STR);

        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم إضافة إدارة  '.$this->name,'departments');
            return true;
        }else{
            return false;
        }

    }
    public static  function getDepartments()
    {
        $user = Auth::getUser();
        if($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT  * FROM departments  where is_delete = 0 AND company=:company ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        if ($row->manager == null) {
                            $row->manager = '-';
                        } else {
                            $manager = employess::findById($row->manager, 'data');
                            $row->manager = $manager->name;
                        }
                        $count = employess::count('id', 'data', 'department', $row->id);

                        $row->count = $count->count;

                    }
                }

                return $data;
            }
        }
    }
    public function editDepartment()
    {

    if($this->manager ==''){
             $this->manager = NULL;
         }

        $sql ='UPDATE  departments
            SET name = :name,
                tasks = :tasks,
                color = :color,
             manager = :manager
                where id = :id
                ';


        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':color', $this->color, PDO::PARAM_STR);
        $stmt->bindValue(':tasks', $this->tasks, PDO::PARAM_STR);
        $stmt->bindValue(':manager', $this->manager , PDO::PARAM_STR);

        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل إدارة  '.$this->name,'departments');
            return true;
        }else{
            return false;
        }

    }
    public function deleteDepartment($id)
    {

        $sql ='UPDATE  departments
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();
        $dep = employess::FindByID($id, 'departments');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف إدارة  '.$dep->name,'departments');
            return true;
        }else{
            return false;
        }

    }



    public function saveJob()
    {

        $sql ='INSERT INTO jobs
                (name,company)
                VALUES (:name,:company)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم إضافة وظيفة  '.$this->name,'jobs');
            return true;
        }else{
            return false;
        }

    }
    public static function getJobs()
    {
        $user = Auth::getUser();
        if($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM jobs  WHERE is_delete = 0 AND company=:company ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {

                        $count = employess::count('id', 'data', 'job', $row->id);

                        $row->count = $count->count;

                    }
                }

                return $data;


            }
        }
    }
    public function editJob()
    {

        $sql ='UPDATE  jobs
            SET name = :name
            where id =:id ';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);

        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل وظيفة  '.$this->name,'jobs');
            return true;
        }else{
            return false;
        }

    }
    public function deleteJob($id)
    {

        $sql ='UPDATE  jobs
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();
        $job = employess::FindByID($id, 'jobs');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف وظيفة  '.$job->name,'jobs');
            return true;
        }else{
            return false;
        }

    }



    public function saveWorkPlace()
    {

        $sql ='INSERT INTO work_places
                (name,company)
                VALUES (:name,:company)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم إضافة موقع عمل   '.$this->name,'work_places');
            return true;
        }else{
            return false;
        }

    }
    public static  function getWorkPlaces()
    {
        $user = Auth::getUser();
        if($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM work_places  where  is_delete = 0 AND company=:company';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {

                        $count = employess::count('id', 'data', 'work_place', $row->id);

                        $row->count = $count->count;

                    }
                }

                return $data;


            }
        }
    }
    public function editWorkPlaces()
    {

        $sql ='UPDATE  work_places
            SET name = :name
            where id =:id ';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);

        $user=Auth::getUser();

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل موقع عمل   '.$this->name,'work_places');
            return true;
        }else{
            return false;
        }

    }
    public function deleteWorkPlaces($id)
    {

        $sql ='UPDATE  work_places
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();
        $work_place= employess::FindByID($id, 'work_places');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف موقع عمل   '.$work_place->name,'work_places');
            return true;
        }else{
            return false;
        }

    }





    public  function getCities()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM cities   where gov_id = :gov_id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':gov_id', $this->id, PDO::PARAM_STR);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            $data = $stmt->fetchAll();

            $output = '';

            if ($data) {
                $output .= '<option value="" disabled>اختر المدينة / المركز</option>';
                foreach ($data as &$row) {
                    $output .= '<option value="'.$row->id.'">'.$row->city_name.'</option>';
                }

            }
            else {
                $output .= '<option value="" disabled>لايوحد بيانات</option>';
            }
            $data = array(
                'cities' => $output,
            );
            return $data;
        }
    }

    public static function  getAllCites()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM cities  ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetchAll();
        }
    }
    public static function  getGovernorates()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM governorates  ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetchAll();
        }
    }
    public static  function getJobApplications()
    {
        $user = Auth::getUser();
        if($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM job_application WHERE is_delete = 0 AND company = :company 
            order by date_of_application desc ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_STR);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();


            }
        }
    }
    public function editJobApplication($file)
    {


        $sql ='UPDATE  job_application
                 SET 
                 name = :name  ,
              telephone = :telephone  ,
               company = :company  ,
               residence_street = :residence_street  ,
              place_of_birth_street  = :place_of_birth_street  ,
            identification_id = :identification_id  , 
            army_status = :army_status  ,
             marital_status  = :marital_status  ,
            qualification_type = :qualification_type  ,
            graduation_date = :graduation_date  , 
            qualification_name = :qualification_name  
            
              ';


        if ($file != null) $sql .= " ,personal_photo = :personal_photo";
        if ($this->date_of_birth != null) $sql .= " ,date_of_birth= :date_of_birth";
        if (isset($this->residence_governorate)) $sql .= " ,residence_governorate=".$this->residence_governorate;
        if (isset($this->residence_city)) $sql .= " ,residence_city=".$this->residence_city;
        if (isset($this->place_of_birth_governorate)) $sql .= " ,place_of_birth_governorate=.$this->place_of_birth_governorate";
        if (isset($this->place_of_birth_city)) $sql .= " ,place_of_birth_city=".$this->place_of_birth_city;
       

        $sql.='  where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $this->telephone, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':residence_street', $this->residence_street, PDO::PARAM_STR);
        $stmt->bindValue(':place_of_birth_street', $this->place_of_birth_street, PDO::PARAM_STR);
        if ($this->date_of_birth != null) $stmt->bindValue(':date_of_birth', $this->date_of_birth, PDO::PARAM_STR);
        $stmt->bindValue(':identification_id', $this->identification_id, PDO::PARAM_INT);
        $stmt->bindValue(':army_status', $this->army_status, PDO::PARAM_STR);
        $stmt->bindValue(':marital_status', $this->marital_status, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_type', $this->qualification_type, PDO::PARAM_STR);
        $stmt->bindValue(':graduation_date', $this->graduation_date, PDO::PARAM_STR);
        $stmt->bindValue(':qualification_name', $this->qualification_name, PDO::PARAM_STR);
        if ($file != null) $stmt->bindValue(':personal_photo', $file, PDO::PARAM_STR);



        $user=Auth::getUser();
        $application = employess::FindByID($this->id, 'job_application');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل طلب التحاق ل   '.$application->name,'job_applications');
            return true;
        }else{
            return false;
        }

    }


    public function okJobApplication($id,$identification_id)
    {


        $sql ='INSERT INTO data (name, telephone,company, residence_governorate,residence_city,residence_street, place_of_birth_governorate,
                 place_of_birth_city,place_of_birth_street ,date_of_birth, identification_id, army_status,
                 marital_status ,qualification_type, graduation_date, qualification_name
                 ,personal_photo )
            SELECT name, telephone,company, residence_governorate,residence_city,residence_street, place_of_birth_governorate,
                 place_of_birth_city,place_of_birth_street ,date_of_birth, identification_id, army_status,
                 marital_status ,qualification_type, graduation_date, qualification_name,
                 personal_photo 
            FROM job_application WHERE  id= :id
              ';


        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);


        $user=Auth::getUser();

        if($stmt->execute()){

            $application = employess::FindByID($id, 'job_application');

            employess::insertNotifications($user->id,'تم إضافة موظف جديد '.$application->name,'employees');


            $sql = "UPDATE  job_application
                SET color  = '#7eff84'
                WHERE id = :id ";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->execute();


            $sql = 'SELECT *  FROM data   where identification_id = :identification_id  AND status =0
            AND company =:company';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':identification_id', $identification_id, PDO::PARAM_INT);
            $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            $data = $stmt->fetch();

            return $data->id;
        }else{
            return false;
        }

    }



    public function deleteJobApplication($id)
    {

        $sql ='UPDATE  job_application
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();
        $application = employess::FindByID($id, 'job_application');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف طلب التحاق ل   '.$application->name,'job_applications');
            return true;
        }else{
            return false;
        }

    }
    public static  function getEmployees()
    {
        $user = Auth::getUser();
        if($user) {
            if(isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM data WHERE status = 0 AND is_delete = 0 AND company=:company AND drop_out = 0 AND army_status!=6
                        order by orderBy asc ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $dep = employess::FindByID($row->department, 'departments');
                        $job = employess::FindByID($row->job, 'jobs');
                        $work_place = employess::findById($row->work_place, 'work_places');
                        $job_status = employess::findByIdNoCom($row->job_status, 'jobs_status');
                        $residence_governorate = employess::findByIdNoCom($row->residence_governorate, 'governorates');
                        $residence_city = employess::findByIdNoCom($row->residence_city, 'cities');
                        $place_of_birth_governorate = employess::findByIdNoCom($row->place_of_birth_governorate, 'governorates');
                        $place_of_birth_city = employess::findByIdNoCom($row->place_of_birth_city, 'cities');
                        $army_status = employess::findByIdNoCom($row->army_status, 'army_status');
                        $marital_status = employess::findByIdNoCom($row->marital_status, 'marital_status');
                        $qualification_type = employess::findByIdNoCom($row->qualification_type, 'qualification_type');
                        if ($dep) {
                            $row->department = $dep->name;
                        }
                        if ($job) {
                            $row->job = $job->name;
                        }
                        if ($work_place) $row->work_place = $work_place->name;
                        if ($job_status) $row->job_status = $job_status->name;

                           if ($row->residence_governorate)$row->residence_governorate = $residence_governorate->governorate_name;
                           
                       if ($row->residence_city) $row->residence_city = $residence_city->city_name;
                       if ($row->place_of_birth_governorate) $row->place_of_birth_governorate = $place_of_birth_governorate->governorate_name;
                        if ($row->place_of_birth_city)$row->place_of_birth_city = $place_of_birth_city->city_name;
                        if ($row->army_status)$row->army_status = $army_status->name;
                       if ($row->marital_status) $row->marital_status = $marital_status->name;
                       if ($row->qualification_type) $row->qualification_type = $qualification_type->name;
                       
                         $from = new DateTime($row->date_of_birth);
                         $to   = new DateTime('today');
                         $row->status = $from->diff($to)->y;
                         
                       $url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        //files
                          if (strpos($url, 'attachments') == true) { if(!is_null($row->personal_photo)) if (file_exists($row->personal_photo)) $row->personal_photo = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->personal_photo = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';}
                        if(!is_null($row->cv))  if (file_exists($row->cv)) $row->cv = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->cv = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->job_application))  if (file_exists($row->job_application)) $row->job_application = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->job_application = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->identification_card))  if (file_exists($row->identification_card)) $row->identification_card = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->identification_card = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->birth_certificate))  if (file_exists($row->birth_certificate)) $row->birth_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->birth_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->qualification_certificate))  if (file_exists($row->qualification_certificate)) $row->qualification_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->qualification_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->army_certificate))  if (file_exists($row->army_certificate)) $row->army_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->army_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->criminal_sheet))  if (file_exists($row->criminal_sheet)) $row->criminal_sheet = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->criminal_sheet = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->training_record))  if (file_exists($row->training_record)) $row->training_record = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->training_record = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->driving_license))  if (file_exists($row->driving_license)) $row->driving_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->driving_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->equipment_license))  if (file_exists($row->equipment_license)) $row->equipment_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->equipment_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';



                    }
                }

                return $data;

            }
        }
    }
    
        public static  function getِArmyEmployees()
    {
        $user = Auth::getUser();
        if($user) {
            if(isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM data WHERE status = 0 AND is_delete = 0 AND company=:company AND drop_out = 0 AND army_status=6
                        order by orderBy asc ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $dep = employess::FindByID($row->department, 'departments');
                        $job = employess::FindByID($row->job, 'jobs');
                        $work_place = employess::findById($row->work_place, 'work_places');
                        $job_status = employess::findByIdNoCom($row->job_status, 'jobs_status');
                        $residence_governorate = employess::findByIdNoCom($row->residence_governorate, 'governorates');
                        $residence_city = employess::findByIdNoCom($row->residence_city, 'cities');
                        $place_of_birth_governorate = employess::findByIdNoCom($row->place_of_birth_governorate, 'governorates');
                        $place_of_birth_city = employess::findByIdNoCom($row->place_of_birth_city, 'cities');
                        $army_status = employess::findByIdNoCom($row->army_status, 'army_status');
                        $marital_status = employess::findByIdNoCom($row->marital_status, 'marital_status');
                        $qualification_type = employess::findByIdNoCom($row->qualification_type, 'qualification_type');
                        if ($dep) {
                            $row->department = $dep->name;
                        }
                        if ($job) {
                            $row->job = $job->name;
                        }
                        if ($work_place) $row->work_place = $work_place->name;
                        if ($job_status) $row->job_status = $job_status->name;

                           if ($row->residence_governorate)$row->residence_governorate = $residence_governorate->governorate_name;
                           
                       if ($row->residence_city) $row->residence_city = $residence_city->city_name;
                       if ($row->place_of_birth_governorate) $row->place_of_birth_governorate = $place_of_birth_governorate->governorate_name;
                        if ($row->place_of_birth_city)$row->place_of_birth_city = $place_of_birth_city->city_name;
                        if ($row->army_status)$row->army_status = $army_status->name;
                       if ($row->marital_status) $row->marital_status = $marital_status->name;
                       if ($row->qualification_type) $row->qualification_type = $qualification_type->name;
                       
                         $from = new DateTime($row->date_of_birth);
                         $to   = new DateTime('today');
                         $row->status = $from->diff($to)->y;
                         
                       $url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        //files
                          if (strpos($url, 'attachments') == true) { if(!is_null($row->personal_photo))  if (file_exists($row->personal_photo)) $row->personal_photo = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->personal_photo = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';}
                        if(!is_null($row->cv))  if (file_exists($row->cv)) $row->cv = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->cv = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->job_application))  if (file_exists($row->job_application)) $row->job_application = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->job_application = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->identification_card))  if (file_exists($row->identification_card)) $row->identification_card = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->identification_card = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->birth_certificate))  if (file_exists($row->birth_certificate)) $row->birth_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->birth_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->qualification_certificate))  if (file_exists($row->qualification_certificate)) $row->qualification_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->qualification_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->army_certificate))  if (file_exists($row->army_certificate)) $row->army_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->army_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->criminal_sheet))  if (file_exists($row->criminal_sheet)) $row->criminal_sheet = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->criminal_sheet = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->training_record))  if (file_exists($row->training_record)) $row->training_record = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->training_record = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->driving_license))  if (file_exists($row->driving_license)) $row->driving_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->driving_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->personal_photo))  if (file_exists($row->equipment_license)) $row->equipment_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->equipment_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';



                    }
                }

                return $data;

            }
        }
    }
    
     public static  function getPensionEmployees()
    {
        $user = Auth::getUser();
        if($user) {
            if(isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM data WHERE status = 0 AND is_delete = 0 AND company=:company AND drop_out = 0 AND job_status=2
                        order by orderBy asc ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $dep = employess::FindByID($row->department, 'departments');
                        $job = employess::FindByID($row->job, 'jobs');
                        $work_place = employess::findById($row->work_place, 'work_places');
                        $job_status = employess::findByIdNoCom($row->job_status, 'jobs_status');
                        $residence_governorate = employess::findByIdNoCom($row->residence_governorate, 'governorates');
                        $residence_city = employess::findByIdNoCom($row->residence_city, 'cities');
                        $place_of_birth_governorate = employess::findByIdNoCom($row->place_of_birth_governorate, 'governorates');
                        $place_of_birth_city = employess::findByIdNoCom($row->place_of_birth_city, 'cities');
                        $army_status = employess::findByIdNoCom($row->army_status, 'army_status');
                        $marital_status = employess::findByIdNoCom($row->marital_status, 'marital_status');
                        $qualification_type = employess::findByIdNoCom($row->qualification_type, 'qualification_type');
                        if ($dep) {
                            $row->department = $dep->name;
                        }
                        if ($job) {
                            $row->job = $job->name;
                        }
                        if ($work_place) $row->work_place = $work_place->name;
                        if ($job_status) $row->job_status = $job_status->name;

                           if ($row->residence_governorate)$row->residence_governorate = $residence_governorate->governorate_name;
                           
                       if ($row->residence_city) $row->residence_city = $residence_city->city_name;
                       if ($row->place_of_birth_governorate) $row->place_of_birth_governorate = $place_of_birth_governorate->governorate_name;
                        if ($row->place_of_birth_city)$row->place_of_birth_city = $place_of_birth_city->city_name;
                        if ($row->army_status)$row->army_status = $army_status->name;
                       if ($row->marital_status) $row->marital_status = $marital_status->name;
                       if ($row->qualification_type) $row->qualification_type = $qualification_type->name;
                       
                         $from = new DateTime($row->date_of_birth);
                         $to   = new DateTime('today');
                         $row->status = $from->diff($to)->y;
                         
                       $url="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        //files
                          if (strpos($url, 'attachments') == true) { if (file_exists($row->personal_photo)) $row->personal_photo = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->personal_photo = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';}
                        if (file_exists($row->cv)) $row->cv = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->cv = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->job_application)) $row->job_application = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->job_application = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->identification_card)) $row->identification_card = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->identification_card = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->birth_certificate)) $row->birth_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->birth_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->qualification_certificate)) $row->qualification_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->qualification_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->army_certificate)) $row->army_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->army_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->criminal_sheet)) $row->criminal_sheet = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->criminal_sheet = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->training_record)) $row->training_record = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->training_record = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->driving_license)) $row->driving_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->driving_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if (file_exists($row->equipment_license)) $row->equipment_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->equipment_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';



                    }
                }

                return $data;

            }
        }
    }
    
    
      public static  function fingerprints()
    {
        $user = Auth::getUser();
        if($user) {
            if(isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM data WHERE status = 0 AND is_delete = 0 AND company=:company  AND fingerprint != ""
                        order by orderBy asc ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $dep = employess::FindByID($row->department, 'departments');
                        $job = employess::FindByID($row->job, 'jobs');
                        $work_place = employess::findById($row->work_place, 'work_places');
                        $residence_governorate = employess::findByIdNoCom($row->residence_governorate, 'governorates');
                        $residence_city = employess::findByIdNoCom($row->residence_city, 'cities');
                        $place_of_birth_governorate = employess::findByIdNoCom($row->place_of_birth_governorate, 'governorates');
                        $place_of_birth_city = employess::findByIdNoCom($row->place_of_birth_city, 'cities');
                        $army_status = employess::findByIdNoCom($row->army_status, 'army_status');
                        $marital_status = employess::findByIdNoCom($row->marital_status, 'marital_status');
                        $qualification_type = employess::findByIdNoCom($row->qualification_type, 'qualification_type');
                        if ($dep) {
                            $row->department = $dep->name;
                        }
                        if ($job) {
                            $row->job = $job->name;
                        }
                        if ($work_place) $row->work_place = $work_place->name;


                      if ($row->residence_governorate)$row->residence_governorate = $residence_governorate->governorate_name;
                           
                       if ($row->residence_city) $row->residence_city = $residence_city->city_name;
                       if ($row->place_of_birth_governorate) $row->place_of_birth_governorate = $place_of_birth_governorate->governorate_name;
                        if ($row->place_of_birth_city)$row->place_of_birth_city = $place_of_birth_city->city_name;
                        if ($row->army_status)$row->army_status = $army_status->name;
                       if ($row->marital_status) $row->marital_status = $marital_status->name;
                       if ($row->qualification_type) $row->qualification_type = $qualification_type->name;

                        //files
                        if(!is_null($row->cv))  if (file_exists($row->cv)) $row->cv = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->cv = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->job_application))  if (file_exists($row->job_application)) $row->job_application = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->job_application = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->identification_card))  if (file_exists($row->identification_card)) $row->identification_card = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->identification_card = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->birth_certificate))  if (file_exists($row->birth_certificate)) $row->birth_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->birth_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->qualification_certificate))  if (file_exists($row->qualification_certificate)) $row->qualification_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->qualification_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->army_certificate))  if (file_exists($row->army_certificate)) $row->army_certificate = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->army_certificate = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->criminal_sheet))  if (file_exists($row->criminal_sheet)) $row->criminal_sheet = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->criminal_sheet = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->training_record))  if (file_exists($row->training_record)) $row->training_record = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->training_record = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->driving_license))  if (file_exists($row->driving_license)) $row->driving_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->driving_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';
                        if(!is_null($row->equipment_license))  if (file_exists($row->equipment_license)) $row->equipment_license = '<i class="fas fa-check-circle fa-3x btn-outline-success"></i>';
                        else $row->equipment_license = '<i class="fas fa-times-circle fa-3x btn-outline-danger"></i>';



                    }
                }

                return $data;

            }
        }
    }


public static  function getJobStatus()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM jobs_status   ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();


        }
    }
    public static  function getArmyStatus()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM army_status   ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();


        }
    }

    public static  function getMaritalStatus()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM marital_status   ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();


        }
    }
    public static  function getQualificationType()
    {
        $user = Auth::getUser();
        if($user) {

            $sql = 'SELECT *  FROM qualification_type   ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();


        }
    }


    public function saveHoliday($file)
    {


        $sql ='INSERT INTO holidays
                (employee ,company ,duration, type,cause,date, file ,notes )
                VALUES (:employee,:company, :duration, :type,:cause,
                        :date, :file,:notes	)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':duration', $this->duration, PDO::PARAM_INT);
        $stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindValue(':cause', $this->cause, PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':file', $file	, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);


        $user=Auth::getUser();

        $employee = self::findById($this->employee,'data');

        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم إضافة أجازة   ل'.$employee->name,'holidays');
            return true;
        }else{
            return false;
        }

    }
    
    public static function getmonth($sum,$table,$date,$val,$col,$val2,$val3){
        $sql = " SELECT Sum(`" . $sum . "`) as sum from `" . $table . "`
         WHERE  MONTH(`" . $date . "`) = :col  AND  `" . $col . "` = :col2 AND YEAR(`" . $date . "`) = :col3 AND company =:company
         AND is_delete = 0" ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val, PDO::PARAM_INT);
        $stmt->bindValue(':col2', $val2, PDO::PARAM_INT);
        $stmt->bindValue(':col3', $val3, PDO::PARAM_INT);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    
    public static function getyear($sum,$table,$date,$val,$col,$val2){
        $sql = " SELECT Sum(`" . $sum . "`) as sum from `" . $table . "`
         WHERE   `" . $col . "` = :col AND YEAR(`" . $date . "`) = :col2 AND company =:company
         AND is_delete = 0" ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':col', $val2, PDO::PARAM_INT);
        $stmt->bindValue(':col2', $val, PDO::PARAM_INT);

        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);


        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    
    public static  function getHolidays()
    {
        $user = Auth::getUser();
        if ($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM holidays  where  is_delete = 0  AND company=:company group by employee ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

                $data = $stmt->fetchAll();
                $HolidayType = [];
                
                $data2 = employess::getHolidayType();

               foreach ($data2 as &$row) {
                     array_push($HolidayType,$row->id);
                }
                if ($data) {
                    $year = date('Y');
            
                    foreach ($data as &$row) {
                        $employee = employess::findById($row->employee, 'data');

                            if($employee){
                         
                        $month1 = employess::getmonth('duration', 'holidays','date',date('m', strtotime('-2 month') ),'employee',$row->employee,$year);
                        $month2 = employess::getmonth('duration', 'holidays','date',date('m', strtotime('-1 month')) ,'employee',$row->employee,$year);
                        $month3 = employess::getmonth('duration', 'holidays','date',date('m', strtotime('0 month')) ,'employee',$row->employee,$year);
                        
                        $year1 = employess::getyear('duration', 'holidays','date',$year ,'employee',$row->employee);

                        $row->cause = $row->employee;
                        $row->employee = $employee->name;

                        $row->month1 = $month1->sum;
                        $row->month2 = $month2->sum;
                        $row->month3 = $month3->sum;
                        
                       $row->year = $year1->sum;
;
                        

                    }
                    }
                }

                return $data;


            }
        }
    }





    public function editHoliday($file)
    {


        $sql ='UPDATE  holidays
                 SET 
            duration = :duration,
            type = :type,
            cause=:cause,
            notes = :notes
              ';

        if ($file != null) $sql .= " ,file='$file'";
        if ($this->date != null) $sql .= " ,date='$this->date'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':duration', $this->duration, PDO::PARAM_INT);
        $stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindValue(':cause', $this->cause, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);

        $user=Auth::getUser();
        $holiday = self::findById($this->id,'holidays');
        $employee = self::findById($holiday->employee,'data');
        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل أجازة لموظف  '.$employee->name,'holidays');
            return true;
        }else{
            return false;
        }

    }

    public function deleteHoliday($id)
    {

        $sql ='UPDATE  holidays
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();

        $holiday = employess::FindByID($id, 'holidays');
        $employee = employess::FindByID($holiday->employee, 'data');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف أجازة لموظف   '.$employee->name,'holidays');
            return true;
        }else{
            return false;
        }

    }




    public static  function getHolidayType()
    {
        $user = Auth::getUser();
        if($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM holidays_type where company = :company  ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();


            }
        }
    }


    public function savePenalty($file)
    {

        $sql ='INSERT INTO penalties
                (employee ,company, type, cause,response,date, file  ,notes)
                VALUES (:employee,:company,:type,:cause,:response,
                        :date, :file, :notes)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindValue(':cause', $this->cause, PDO::PARAM_STR);
        $stmt->bindValue(':response', $this->response, PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':file', $file	, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);



        $user=Auth::getUser();

        $employee = self::findById($this->employee,'data');

        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم إضافة جزاء   ل'.$employee->name,'penalties');
            return true;
        }else{
            return false;
        }

    }

    public static  function getPenalties()
    {
        $user = Auth::getUser();
        if ($user) {
            if (isset($_COOKIE['company'])) {


                $sql = 'SELECT *  FROM penalties  where  is_delete = 0 AND company=:company group by employee ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $employee = employess::findById($row->employee, 'data');
                        $row->cause = $row->employee;
                        $row->employee = $employee->name;
                    }
                }

                return $data;


            }
        }
    }

    public function editPenalty($file)
    {


        $sql ='UPDATE  penalties
                 SET 
            response = :response,
            type = :type,
            cause=:cause,
            notes = :notes
              ';

        if ($file != null) $sql .= " ,file='$file'";
        if ($this->date != null) $sql .= " ,date='$this->date'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':response', $this->response, PDO::PARAM_STR);
        $stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindValue(':cause', $this->cause, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);

        $user=Auth::getUser();
        $penalty = self::findById($this->id,'penalties');
        $employee = self::findById($penalty->employee,'data');
        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل جزاء لموظف  '.$employee->name,'penalties');
            return true;
        }else{
            return false;
        }

    }

    public function deletePenalty($id)
    {

        $sql ='UPDATE  penalties
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();

        $penalty = employess::FindByID($id, 'penalties');
        $employee = employess::FindByID($penalty->employee, 'data');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف جزاء لموظف   '.$employee->name,'penalties');
            return true;
        }else{
            return false;
        }

    }

    public static  function getPenaltyType()
    {
        $user = Auth::getUser();
        if($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM penalties_type  where company =:company ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();


            }
        }
    }
    public function saveInsurance($file)
    {


        $sql ='INSERT INTO insurances
                (employee ,company, number , type,date, file ,notes )
                VALUES (:employee, :company, :number, :type,
                        :date, :file,:notes	)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':employee', $this->employee, PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);
        $stmt->bindValue(':number', $this->number, PDO::PARAM_STR);
        $stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
        $stmt->bindValue(':file', $file	, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);


        $user=Auth::getUser();

        $employee = self::findById($this->employee,'data');

        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم إضافة تأمين   ل'.$employee->name,'insurances');
            return true;
        }else{
            return false;
        }

    }
    public static  function getInsurances()
    {
        $user = Auth::getUser();
        if ($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM insurances  where  is_delete = 0 AND company=:company group by employee ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $employee = employess::findById($row->employee, 'data');
                        $row->notes = $row->employee;
                        $row->employee = $employee->name;
                    }
                }

                return $data;


            }
        }
    }

    public function editInsurance($file)
    {


        $sql ='UPDATE  insurances
                 SET 
            number = :number,
            type = :type,
            notes = :notes
              ';

        if ($file != null) $sql .= " ,file='$file'";
        if ($this->date != null) $sql .= " ,date='$this->date'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':number', $this->number, PDO::PARAM_STR);
        $stmt->bindValue(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindValue(':notes', $this->notes	, PDO::PARAM_STR);

        $user=Auth::getUser();
        $insurance = self::findById($this->id,'insurances');
        $employee = self::findById($insurance->employee,'data');
        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم تعديل تأمين لموظف  '.$employee->name,'insurances');
            return true;
        }else{
            return false;
        }

    }

    public function deleteInsurance($id)
    {

        $sql ='UPDATE  insurances
               SET
               is_delete = 1
               where 
                id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();

        $insurance = employess::FindByID($id, 'insurances');
        $employee = employess::FindByID($insurance->employee, 'data');

        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف تأمين لموظف   '.$employee->name,'insurances');
            return true;
        }else{
            return false;
        }

    }


    public static  function getInsuranceType()
{
    $user = Auth::getUser();
    if($user) {
        if (isset($_COOKIE['company'])) {

            $sql = 'SELECT *  FROM insurances_type where  company =:company ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return $stmt->fetchAll();


        }

    }
}




public static function checkDate()
{
    $user = Auth::getUser();
    if($user) {
        if (isset($_COOKIE['company'])) {

            date_default_timezone_set("Africa/Cairo");

            $date = date('Y-m-d');

            $sql = 'SELECT *  FROM salaries where  company =:company and is_delete =0  ';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            $data = $stmt->fetchAll();
            $result = true;
            if ($data) {
                foreach ($data as &$row) {
                    $date1= date_parse_from_format("Y-m-d", $row->date);
                    $date2= date_parse_from_format("Y-m-d", $date);
                    if($date1['month'] == $date2['month'] and  $date1['year'] == $date2['year']){
                        $result = false;
                        break;
                    }
                }
            }
            return $result;
        }
    }
}
public function saveSalaries()
{
    date_default_timezone_set("Africa/Cairo");
    $date = date('Y-m-d');
    $date1= date_parse_from_format("Y-m-d", $date);
    $check = employess::checkDate();
    if($check){
    for($i=1;$i<= $this->count;$i++){

        $sql ='INSERT INTO salaries
                (user_id,minus,plus,filter,date,date_id,company)
                VALUES (:id,:minus,:plus,:filter,:date,:date_id,:company)';

        $db = static::getDB();
        $stmt =$db->prepare($sql);



        $stmt->bindValue(':id', $this->{'id'.$i}, PDO::PARAM_STR);
        $stmt->bindValue(':minus', $this->{'minus'.$i}, PDO::PARAM_STR);
        $stmt->bindValue(':plus', $this->{'plus'.$i}, PDO::PARAM_STR);
        $stmt->bindValue(':filter', $this->{'filter'.$i}, PDO::PARAM_STR);
        $stmt->bindValue(':date',date('Y-m-d H-i-s'), PDO::PARAM_STR);
        $stmt->bindValue(':date_id',    $date1['month'].'-'.$date1['year'], PDO::PARAM_STR);
        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

        if($stmt->execute()){
            $result=true;
        }
    }

    $user=Auth::getUser();
    if($result){
        employess::insertNotifications($user->id,'تم  إضافة شهر رواتب جديد    '.$date1['month'].'-'.$date1['year'],'salaries');
        return true;
    }else{
        return false;
    }
    }
}

    public static  function getSalaries()
    {
        $user = Auth::getUser();
        if ($user) {
            if (isset($_COOKIE['company'])) {

                $sql = 'SELECT *  FROM salaries  where  is_delete = 0  AND company=:company  group by date_id ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $date = date('Y-m-d');
                        $date1= date_parse_from_format("Y-m-d", $date);

                        $row->user_id = $date1['month'];
                        $row->company =  $date1['year'];

                    }
                }

                return $data;

            }
        }
    }

    public function editSalaries()
    {
        date_default_timezone_set("Africa/Cairo");
        $date = date('Y-m-d');
        $date1= date_parse_from_format("Y-m-d", $date);
            for($i=1;$i<= $this->count;$i++){

                $sql ='UPDATE  salaries
                SET
                minus =:minus,
                plus =:plus,
                filter =:filter,
                date =:date,
                date_id =:date_id,
                company =:company
               where  id =:id';

                $db = static::getDB();
                $stmt =$db->prepare($sql);



                $stmt->bindValue(':id', $this->{'id'.$i}, PDO::PARAM_STR);
                $stmt->bindValue(':minus', $this->{'minus'.$i}, PDO::PARAM_STR);
                $stmt->bindValue(':plus', $this->{'plus'.$i}, PDO::PARAM_STR);
                $stmt->bindValue(':filter', $this->{'filter'.$i}, PDO::PARAM_STR);
                $stmt->bindValue(':date',date('Y-m-d H-i-s'), PDO::PARAM_STR);
                $stmt->bindValue(':date_id',    $date1['month'].'-'.$date1['year'], PDO::PARAM_STR);
                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                if($stmt->execute()){
                    $result=true;
                }
            }

            $user=Auth::getUser();
            if($result){
                employess::insertNotifications($user->id,'تم  تعديل شهر رواتب جديد    '.$date1['month'].'-'.$date1['year'],'salaries');
                return true;
            }else{
                return false;
            }
        }



    public function deleteSalary($id)
    {

        $sql ='UPDATE  salaries
               SET
               is_delete = 1
               where 
                date_id = :id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $user=Auth::getUser();


        if($stmt->execute()){
            employess::insertNotifications($user->id,'تم حذف شهر    '.$id,'salaries');
            return true;
        }else{
            return false;
        }

    }

    public function updateSalary($salaries,$id)
    {
        date_default_timezone_set("Africa/Cairo");
        $data = $this->getEmployees();
                foreach ($salaries as &$row2) {
                    foreach ($data as &$row) {
                        if ($row->id == $row2->user_id) {
                            $row->name = 0;
                        }
                    }
                }

        foreach ($data as &$row) {
            if ( $row->name != '0') {

                $sql ='INSERT INTO salaries
                (user_id,date,date_id,company)
                VALUES (:id,:date,:date_id,:company)';

                $db = static::getDB();
                $stmt =$db->prepare($sql);



                $stmt->bindValue(':id',  $row->id, PDO::PARAM_STR);
                $stmt->bindValue(':date',date('Y-m-d H-i-s'), PDO::PARAM_STR);
                $stmt->bindValue(':date_id',    $id, PDO::PARAM_STR);
                $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->execute();

            }
        }
    }


    public static function stats(){
    if (isset($_COOKIE['company'])) {


        $employees = self::countTwo('id', 'data', 'status', '0','drop_out', '0');
        $departments = self::count('id', 'departments', 'is_delete', '0');
        $work_places = self::count('id', 'work_places', 'is_delete', '0');
        $propertiesToSet = array(
            "emp" => $employees->count,
            "dep" => $departments->count,
            "work" => $work_places->count);
        $data = new employess();
        foreach ($propertiesToSet as $property => $value) {
            // same as $myObject->var1 = "test value 1";
            $data->$property = $value;
        }
        return $data;
    }
    }
    public  static function Exists($val,$col,$table)
    {
        $sql = "SELECT * FROM `" . $table . "`  where  `" . $col . "` = :col AND company = :company 
                 AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':col', $val, PDO::PARAM_STR);

        $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $count = $stmt->rowCount();


        if($count == 0){
                return false;
        }
        return true;
    }
    public static function insertNotifications($user_id,$body,$domain){

        date_default_timezone_set("Africa/Cairo");
        $domain ="../".$domain."/report";

        $sql = "SELECT * FROM users  ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $data = $stmt->fetchAll();
        $user = Auth::getUser();
        if($user->id =='29'){
            if (isset($_COOKIE['company'])) {
            employess::insertNotificationsAdmin($user_id,$body,'1',$domain, $_COOKIE['company']);
            }
        }else{
        if ($data) {
            if (isset($_COOKIE['company'])) {

                foreach ($data as &$row) {
                    $notifications = 'notifications_' . $row->notification_id;


                    $sql = "INSERT INTO `" . $notifications . "`
                (user_id,user_type ,body,date,company,domain )
                VALUES (:user_id,:user_type, :body,:date,:company,:domain)";

                    $db = static::getDB();
                    $stmt = $db->prepare($sql);

                    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                    $stmt->bindValue(':user_type', $user->auth, PDO::PARAM_STR);
                    $stmt->bindValue(':company', $_COOKIE['company'], PDO::PARAM_STR);
                    $stmt->bindValue(':domain', $domain, PDO::PARAM_STR);
                    $stmt->bindValue(':body', $body, PDO::PARAM_STR);
                    $stmt->bindValue(':date', date('Y-m-d H-i-s', time()), PDO::PARAM_STR);


                    $stmt->execute();
                }
            }
        }
        }

    }
    public static function insertNotificationsAdmin($user_id,$body,$type,$domain,$company){

        date_default_timezone_set("Africa/Cairo");

        $domain ="../".$domain."/report";

        $sql = "SELECT * FROM users  ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $data = $stmt->fetchAll();
        if ($data) {
            if (isset($_COOKIE['company']))
            {
                if($_COOKIE['company'] != '0' ){
                    $company = $_COOKIE['company'] ;
                }
            }



                    $sql = "INSERT INTO notifications
                (user_id,user_type ,body,date,company,domain )
                VALUES (:user_id,:user_type, :body,:date,:company,:domain)";

                    $db = static::getDB();
                    $stmt = $db->prepare($sql);

                    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                    $stmt->bindValue(':user_type', $type, PDO::PARAM_STR);
                    $stmt->bindValue(':company',$company, PDO::PARAM_STR);
                    $stmt->bindValue(':domain', $domain, PDO::PARAM_STR);
                    $stmt->bindValue(':body', $body, PDO::PARAM_STR);
                    $stmt->bindValue(':date', date('Y-m-d H-i-s', time()), PDO::PARAM_STR);


                    $stmt->execute();
                
            }


    }

    public  function notifications()
    {
        $user = Auth::getUser();

        $notifications = 'notifications';

        if (isset($this->view)) {

            if($user->id =='29'){$search ="user_id != 29 AND user_id != 1" ;}
            if($user->id !='29'){$search ="user_type =".$user->auth ;}

            if ($this->view != '') {

                $sql = "UPDATE `" . $notifications . "`
                SET status = 1 
                WHERE status = 0 ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->execute();

            }

            $sql = "SELECT * FROM `" . $notifications . "` WHERE   $search  ORDER BY date DESC LIMIT 5 ";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            $data = $stmt->fetchAll();

            $output = '';

            if ($data) {
                foreach ($data as &$row) {
                    $user =User::FindByID($row->user_id);
                    $company =employess::findByIdNoCom($row->company,'companies');
                    $output .= '
                  <a href="'.$row->domain.'" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                       
                            <img src="../'.$user->personal_photo.'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title" style="text-align: center">
                                   ' . $user->name . '
                                </h3>
                              <p class="text-sm"  style="text-align: center"> ' . $company->name_ar	 . '</p>
                                <p class="text-sm"  style="text-align: center"> ' . $row->body . '</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ' . $row->date . '</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
             
                         ';
                }
                $output.='<a href="../notifications/index" class="dropdown-item dropdown-footer">عرض كل الاشعارات</a>';
            } else {
                $output.='<a href="#" class="dropdown-item dropdown-footer">لا توجد إشعارات</a>';
            }

            $sql = "SELECT * FROM `" . $notifications . "` where status = 0 AND $search";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();
            $count = $stmt->rowCount();

            $data = array(
                'notification' => $output,
                'unseen_notification' => $count
            );
            return $data;
        }
    }

    public static function getNotifications()
    {
        $user = Auth::getUser();
        if($user){
            
            // if($user->id == '29') $user->auth = 1;

           
                $search = "user_type =" . $user->auth;
            



            $sql = "SELECT * FROM notifications where  $search";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();
            $data = $stmt->FetchAll();
            
            foreach($data as &$row){
                $name = User::FindByIDNO($row->user_id);
                $row->user_id = $name->name;
                
                $name = employess::findByIdNoCom($row->company,'companies');
                $row->company = $name->name_ar;
                
            }
            return $data;
            
        }
    }
     public static function getfingerprint($fingerprint)
    {
        $user = Auth::getUser();
        date_default_timezone_set('Africa/Cairo');
        $date = date('Y-m-d H-i-s', time());
        if($user){
            
         $sql = "SELECT  * 
            FROM(
         SELECT *
            FROM fp_cranes
        WHERE  fingerprint = :fingerprint and date <= :date  
        UNION ALL
        SELECT *
        FROM fp_hoffice
        WHERE  fingerprint = :fingerprint and date <= :date  
         UNION ALL
        SELECT *
        FROM fp_mitco
        WHERE  fingerprint = :fingerprint and date <= :date 
         UNION ALL
        SELECT *
        FROM fp_mlps 
        WHERE  fingerprint = :fingerprint and date <= :date  
         UNION ALL
        SELECT *
        FROM fp_sa7a
        WHERE  fingerprint = :fingerprint and date <= :date  
          UNION ALL
        SELECT *
        FROM fp_sader
        WHERE  fingerprint = :fingerprint and date <= :date  )dum
        order by  date desc
               " ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':fingerprint', $fingerprint, PDO::PARAM_STR);
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

            return $stmt->FetchAll();
        }
    }
         public static function getfingerprintpost($fingerprint,$from,$to)
    {
        $user = Auth::getUser();
        if($user){
            $sql = "
            SELECT  * 
            FROM(
         SELECT *
            FROM fp_cranes
        WHERE  fingerprint = :fingerprint AND date(Date) between  :from AND :to
        UNION ALL
        SELECT *
        FROM fp_hoffice
        WHERE  fingerprint = :fingerprint AND date(Date) between  :from AND :to
         UNION ALL
        SELECT *
        FROM fp_mitco
        WHERE  fingerprint = :fingerprint AND date(Date) between  :from AND :to
         UNION ALL
        SELECT *
        FROM fp_mlps
        WHERE  fingerprint = :fingerprint AND date(Date) between  :from AND :to
         UNION ALL
        SELECT *
        FROM fp_sa7a
        WHERE  fingerprint = :fingerprint AND date(Date) between  :from AND :to
           UNION ALL
        SELECT *
        FROM fp_sader
        WHERE  fingerprint = :fingerprint AND date(Date) between  :from AND :to)dum
        order by  date desc
          
               " ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
       $stmt->bindValue(':fingerprint', $fingerprint, PDO::PARAM_STR);
        $stmt->bindValue(':from', $from, PDO::PARAM_STR);
        $stmt->bindValue(':to', $to, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

            return $stmt->FetchAll();
        }
    }
    
             public static function getholidayspost($id,$from,$to)
    {
        $user = Auth::getUser();
        if($user){
            
         $sql = "SELECT * FROM holidays
            
         where  employee = :id AND
         date between :from AND :to
               " ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':from', $from, PDO::PARAM_STR);
        $stmt->bindValue(':to', $to, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

            return $stmt->FetchAll();
        }
    }
    



}