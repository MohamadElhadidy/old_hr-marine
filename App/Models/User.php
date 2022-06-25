<?php

namespace App\Models;

use App\Auth;
use App\upload_file;
use DateTime;
use DateTimeZone;
use App\Mail;
use PDO;
use  App\token;
use Core\View;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{




    /* error massages     */
    public $errors = [];
    /**
     * @var string
     */


    /**
     * Get all the users as an associative array
     *
     * @param array $data
     */

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save($file)
    {
        $user =Auth::getUser();
        $this->validate();
        if (empty($this->errors)) {


            $notification_id = round(microtime(true));
            if ($this->createNotification($notification_id)) {

                $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
                $token = new token();
                $hashed_token = $token->getHash();
                $this->activation_token = $token->getValue();

                $sql = 'INSERT INTO users(name, email, password_hash,activation_hash,personal_photo,notification_id,auth )
                VALUES (:name, :email, :password,:activation_hash,:personal_photo,:notification_id,2 )';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindValue(':personal_photo', $file, PDO::PARAM_STR);
                $stmt->bindValue(':notification_id', $notification_id, PDO::PARAM_INT);
                $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);
                $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);


                if($stmt->execute()){
                   $users= User::FindByEmail($this->email);

                    $companies =employess::companies();
                    foreach ($companies as &$row){

                        $sql = "INSERT INTO company_permission (user_id,company_id ,permission)
                        VALUES ('$users->id', '$row->id', 0 )";

                        $db = static::getDB();
                        $stmt = $db->prepare($sql);

                        $stmt->execute();
                        }
                    employess::insertNotifications($user->id,'تم إنشاء  حساب :  '.$this->name,'admin');
                    return true;
                }

            }
        }

        return false;
    }

    public function edit($file)
    {
        $user=Auth::getUser();
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

        $companies =employess::companies();
        if (isset($this->department)){

            $sql ="INSERT INTO  department_permission (user_id , department_id) 
                VALUES (:user_id , :department_id)    ";
            $db = static::getDB();
            $stmt =$db->prepare($sql);

            $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':department_id', $this->department, PDO::PARAM_INT);

            $stmt->execute();
        }


                $i=1;
              foreach ($companies as &$row){
                  $c =$i;
                    $st = $this->{'st'.$i};
                  //job Applications
                  $ja=$this->{'jaV'.$i}.$this->{'jaR'.$i}.$this->{'jaA'.$i}.$this->{'jaE'.$i}.$this->{'jaD'.$i}.$this->{'jaP'.$i};

                  $em=$this->{'emV'.$i}.$this->{'emR'.$i}.$this->{'emA'.$i}.$this->{'emE'.$i}.$this->{'emD'.$i}.$this->{'emP'.$i};

                  $de=$this->{'deV'.$i}.$this->{'deR'.$i}.$this->{'deA'.$i}.$this->{'deE'.$i}.$this->{'deD'.$i}.$this->{'deP'.$i};

                  $jo=$this->{'joV'.$i}.$this->{'joR'.$i}.$this->{'joA'.$i}.$this->{'joE'.$i}.$this->{'joD'.$i}.$this->{'joP'.$i};

                  $wp=$this->{'wpV'.$i}.$this->{'wpR'.$i}.$this->{'wpA'.$i}.$this->{'wpE'.$i}.$this->{'wpD'.$i}.$this->{'wpP'.$i};

                  $ins=$this->{'insV'.$i}.$this->{'insR'.$i}.$this->{'insA'.$i}.$this->{'insE'.$i}.$this->{'insD'.$i}.$this->{'insP'.$i};

                  $ho=$this->{'hoV'.$i}.$this->{'hoR'.$i}.$this->{'hoA'.$i}.$this->{'hoE'.$i}.$this->{'hoD'.$i}.$this->{'hoP'.$i};

                  $dr=$this->{'drV'.$i}.$this->{'drR'.$i}.$this->{'drA'.$i}.$this->{'drE'.$i}.$this->{'drD'.$i}.$this->{'drP'.$i};

                  $pe=$this->{'peV'.$i}.$this->{'peR'.$i}.$this->{'peA'.$i}.$this->{'peE'.$i}.$this->{'peD'.$i}.$this->{'peP'.$i};

                  $di=$this->{'diV'.$i}.$this->{'diR'.$i}.$this->{'diA'.$i}.$this->{'diE'.$i}.$this->{'diD'.$i}.$this->{'diP'.$i};

                  $fp=$this->{'fpV'.$i}.$this->{'fpR'.$i}.$this->{'fpP'.$i};

                  $sa=$this->{'saV'.$i}.$this->{'saR'.$i}.$this->{'saA'.$i}.$this->{'saE'.$i}.$this->{'saD'.$i}.$this->{'saP'.$i};

                  $te=$this->{'teV'.$i}.$this->{'teR'.$i}.$this->{'teA'.$i}.$this->{'teE'.$i}.$this->{'teD'.$i}.$this->{'teP'.$i};





                  $sql ="UPDATE  company_permission
                       SET
                     st=:st,
                    ja = :ja,
                    em = :em,
                    de = :de,
                    jo = :jo,
                     wp = :wp,   
                     ins = :ins,
                    ho = :ho,
                    dr = :dr,
                    pe = :pe,
                     di = :di,
                     fp = :fp,
                    sa = :sa,
                    te = :te
                   where user_id ='$this->id' AND company_id =:company_id
                    ";
                  $db = static::getDB();
                  $stmt =$db->prepare($sql);
                  $stmt->bindValue(':st', $st, PDO::PARAM_STR);
                  $stmt->bindValue(':ja', $ja, PDO::PARAM_STR);
                  $stmt->bindValue(':em', $em, PDO::PARAM_STR);
                  $stmt->bindValue(':de', $de, PDO::PARAM_STR);
                  $stmt->bindValue(':jo', $jo, PDO::PARAM_STR);
                  $stmt->bindValue(':wp', $wp, PDO::PARAM_STR);
                  $stmt->bindValue(':ins', $ins, PDO::PARAM_STR);
                  $stmt->bindValue(':ho', $ho, PDO::PARAM_STR);
                  $stmt->bindValue(':dr', $dr, PDO::PARAM_STR);
                  $stmt->bindValue(':pe', $pe, PDO::PARAM_STR);
                  $stmt->bindValue(':di', $di, PDO::PARAM_STR);
                  $stmt->bindValue(':fp', $fp, PDO::PARAM_STR);
                  $stmt->bindValue(':sa', $sa, PDO::PARAM_STR);
                  $stmt->bindValue(':te', $te, PDO::PARAM_STR);
                  $stmt->bindValue(':company_id',$c, PDO::PARAM_INT);

                  $stmt->execute();

                  $short =$row->name_short;
                  if(isset($this->$short) ){

                      $sql ="UPDATE  company_permission
                     SET 
               permission = 1
                   where user_id ='$this->id' AND company_id ='$row->id'
                  ";
                      $db = static::getDB();
                      $stmt =$db->prepare($sql);
                      $stmt->execute();

                  }
                  else{
                      $sql ="UPDATE  company_permission
                       SET
                   permission = 0
                   where user_id ='$this->id' AND company_id ='$row->id'
                    ";
                      $db = static::getDB();
                      $stmt =$db->prepare($sql);
                        $stmt->execute();

                  }
                  $i++;
          }

        $sql ='UPDATE  users
                 SET 
            name = :name,
            email = :email,
            auth = :auth
              ';

        if ($file != null) $sql .= " ,personal_photo='$file'";
        if ($this->password != null) $sql .= " ,password_hash='$password_hash'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':auth', $this->auth, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);



        if($stmt->execute()){

            employess::insertNotifications($user->id,'تم تعديل  حساب  :  '.$this->name,'admin');
            return true;
        }else{
            return false;
        }

    }

    public function saveProfile($file)
    {
        $user=Auth::getUser();
        $password_hash = password_hash($this->password, PASSWORD_DEFAULT);


        $sql ='UPDATE  users
                 SET 
            name = :name
              ';

        if ($file != null) $sql .= " ,personal_photo='$file'";
        if ($this->password != null) $sql .= " ,password_hash='$password_hash'";


        $sql.='where id =:id';

        $db = static::getDB();
        $stmt =$db->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);



        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }





    public function validate()
    {
        //name
        if ($this->name == '') {
            $this->errors[] = 'يجب إدخال الاسم';
        }

        //email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == false) {
            $this->errosr[] = 'الإيميل غير صحيح';
        }
        if (static:: email_Exists($this->email, $this->id ?? null)) {
            $this->errors[] = 'الإيميل موجود بالفعل ';
        }


        //password
        if (strlen($this->password) < 6) {
            $this->errors[] = 'يجب على كلمة المرور ان تتكون على الاقل   6 حروف ';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'يجب على كلمة المرور ان يكون فيها حرف واحد على الاقل ';
        }
        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'يجب على كلمة المرور ان يكون فيها رقم واحد على الاقل ';
        }

    }

    public function validatePassword($password, $new_password)
    {
        if (strlen($password) < 6) {
            $this->errors[] = 'يجب على كلمة المرور ان تتكون على الاقل   6 حروف ';
        }

        if (preg_match('/.*[a-z]+.*/i', $password) == 0) {
            $this->errors[] = 'يجب على كلمة المرور ان يكون فيها حرف واحد على الاقل ';
        }
        if (preg_match('/.*\d+.*/i', $password) == 0) {
            $this->errors[] = 'يجب على كلمة المرور ان يكون فيها رقم واحد على الاقل ';
        }
        //new password
        if (strlen($new_password) < 6) {
            $this->errors[] = 'يجب على كلمة المرور ان تتكون على الاقل   6 حروف ';
        }

        if (preg_match('/.*[a-z]+.*/i', $new_password) == 0) {
            $this->errors[] = 'يجب على كلمة المرور ان يكون فيها حرف واحد على الاقل ';
        }
        if (preg_match('/.*\d+.*/i', $new_password) == 0) {
            $this->errors[] = 'يجب على كلمة المرور ان يكون فيها رقم واحد على الاقل ';
        }
    }

    public static function email_Exists($email, $ignore_id = null)
    {

        $user = static::FindByEmail($email);
        if ($user) {
            if ($user->id != $ignore_id) {
                return true;
            }
        }
        return false;
    }

    public static function FindByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email AND is_delete = 0';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function authenticate($email, $password)
    {
        $user = static::FindByEmail($email);
        if ($user && $user->is_active) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
            return false;
        }
    }

    public static function FindByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id and is_delete = 0';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    
     public static function FindByIDNO($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    public function rememberLogin()
    {
        $token = new token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 365; //365 days

        $sql = 'INSERT INTO remembered_logins(token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H-i-s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();

    }

    public static function sendPasswordReset($email)
    {
        $user = static::FindByEmail($email);
        if ($user) {

            if ($user->startPasswordReset()) {
                $user->sendPasswordResetEmail();
            }

        }
    }

    protected function startPasswordReset()
    {
        $token = new Token();
        $token_hash = $token->getHash();
        $this->password_reset_token = $token->getValue();

        $expiry_timestamp = time() + 60 * 60 * 2; //2 hours

        $sql = 'UPDATE users
            SET password_reset_hash = :token_hash,
                password_reset_expire = :expires_at
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H-i-s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    protected function sendPasswordResetEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/hr/public/password/reset/' . $this->password_reset_token;

        $text = View::getTemplate('password/reset_email.txt', [
            "url" => $url
        ]);
        $html = View::getTemplate('password/reset_email.html', [
            "url" => $url
        ]);

        Mail::send($this->email, 'password reset', $text, $html);

    }

    public static function findByPasswordReset($token)
    {
        $token = new token($token);
        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM users 
        WHERE password_reset_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {
            if (strtotime($user->password_reset_expire) > time()) {
                return $user;
            }
        }


    }

    public function resetPassword($password)
    {
        $this->password = $password;
        $this->validate();
        if (empty($this->errors)) {
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
            SET 
                password_hash = :password_hash,
                password_reset_hash = null,
                password_reset_expire = null
                WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();


        }
        return false;

    }

    public function sendActivationEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/hr/public/signup/activate/' . $this->activation_token;

        $text = View::getTemplate('Signup/activation_email.txt', [
            "url" => $url
        ]);
        $html = View::getTemplate('Signup/activation_email.html', [
            "url" => $url
        ]);

        Mail::send($this->email, 'Account Activaton', $text, $html);

    }

    public static function activate($value)
    {
        $token = new Token($value);
        $hashed_token = $token->getHash();


        $sql = 'UPDATE users
            SET is_active = 1,
                activation_hash  = null
                WHERE activation_hash  = :hashed_token';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function getAllUser()
    {
       

            $sql = 'SELECT *  FROM users where is_delete = 0';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();


    }
    
      public static function getAllUserForN()
    {
            $sql = 'SELECT *  FROM users';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();

    }
    public  static function ExistsUser($val,$col)
    {
        $sql = "SELECT * FROM users  where  `" . $col . "` = :col 
                 AND is_delete = 0";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':col', $val, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $count = $stmt->rowCount();


        if($count == 0){
            return false;
        }
        return true;
    }
    public function createNotification($notification_id)
    {
        $notifications = 'notifications_' . $notification_id;
        $sql = "  CREATE TABLE `" . $notifications . "` (
      `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `user_type` int(11) NOT NULL,
     `company` int(11) NOT NULL,
     `domain` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $sql = "ALTER TABLE `" . $notifications . "`
  ADD KEY `user_id` (`user_id`)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $foreign_key = $notifications . '_ibfk_1';

        $sql = "ALTER TABLE `" . $notifications . "`
  ADD CONSTRAINT `" . $foreign_key . "` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $sql = "ALTER TABLE `" . $notifications . "`
  ADD KEY `user_type` (`user_type`)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $foreign_key = $notifications . '_ibfk_2';

        $sql = "ALTER TABLE `" . $notifications . "`
  ADD CONSTRAINT `" . $foreign_key . "` FOREIGN KEY (`user_type`) REFERENCES `users_type` (`id`) ON UPDATE CASCADE";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
         $stmt->execute();

        $sql = "ALTER TABLE `" . $notifications . "`
  ADD KEY `company` (`company`)";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $foreign_key = $notifications . '_ibfk_3';

        $sql = "ALTER TABLE `" . $notifications . "`
  ADD CONSTRAINT `" . $foreign_key . "` FOREIGN KEY (`company`) REFERENCES `companies` (`id`) ON UPDATE CASCADE";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute();
    }

    public static function getUsers()
    {
        $user = Auth::getUser();
        if ($user) {
            if ($user->id == '29') {

                $sql = 'SELECT  * FROM users where is_delete = 0 ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $data = $stmt->fetchAll();
                if ($data) {
                    foreach ($data as &$row) {
                        $type = employess::findByIdNoCom($row->auth, 'users_type');
                        $row->auth = $type->name;

                    }
                }
                return $data;
            }
        }
    }
    public static function getCompaniesPermission()
    {
        $user = Auth::getUser();
        if ($user) {

                $sql = "SELECT  * FROM company_permission  where user_id = '$user->id' AND permission = 1 ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();


        }
    }
    public static function getPermission()
    {
        $user = Auth::getUser();

        if ($user) {
            if(isset( $_COOKIE['company'])) {

                $sql = "SELECT  * FROM company_permission where user_id ='$user->id'
                         AND  permission = 1 AND company_id =:company_id ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':company_id', $_COOKIE['company'], PDO::PARAM_INT);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetch();
            }

        }
    }

    public static function permission($id)
    {
        $user = Auth::getUser();
        if ($user) {
            if ($user->id == '29') {

                $sql = "SELECT  * FROM company_permission where user_id ='$id'
                 ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();

            }
        }
    }


    public static function getUserTypes()
    {
        $user = Auth::getUser();
        if ($user) {
            if ($user->id == '29') {

                $sql = 'SELECT  * FROM users_type ';

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();

            }
        }
    }
    public static function requireCompany()
    {
        $user = Auth::getUser();
        if ($user) {

                $sql = 'SELECT  * FROM company_permission 
                where user_id = :user_id AND 
                    company_id = :company_id AND permission = 1';

                $db = static::getDB();
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
                $stmt->bindValue(':company_id', $_COOKIE['company'], PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();

        }
    }
    public static function department_permission($id)
    {
        $user = Auth::getUser();
        if ($user) {
            if ($user->id == '29') {

                $sql = "SELECT  * FROM department_permission where user_id ='$id'
                       ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                return $stmt->fetchAll();

            }
        }
    }
    public static function deleteUser($id)
    {
        $user = Auth::getUser();
        if ($user) {
            if ($user->id == '29') {

                $sql = "UPDATE users
                  SET 
                      is_delete = 1
                       where id ='$id'  ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                 $stmt->execute();

                $sql = "UPDATE company_permission
                  SET 
                       permission = 0,
                        st=0,
                    ja = 0,
                    em = 0,
                    de = 0,
                    jo = 0,
                     wp = 0,   
                     ins = 0,
                    ho = 0,
                    dr = 0,
                    pe = 0,
                     di = 0,
                     fp = 0,
                    sa = 0,
                    te = 0
                       where user_id ='$id'  ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                 $stmt->execute();

                $sql = "DELETE  FROM department_permission where user_id ='$id'  ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $users = employess::findByIdNoCom($id,'users');
                if($stmt->execute()) {
                    employess::insertNotifications('1', 'تم حذف  حساب  :  ' . $users->name,'admin');
                    return true;
                }


            }
        }
    }
    public static function deleteDepartment($id)
    {
        $user = Auth::getUser();
        if ($user) {
            if ($user->id == '29') {

                $sql = "DELETE  FROM department_permission where id ='$id'  ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                return $stmt->execute();

            }
        }
    }

    public  function online()
{
    $date = new DateTime("now", new DateTimeZone('Africa/Cairo'));
    $user = Auth::getUser();
    if ($user) {
            $sql = "SELECT  * FROM users_online where user_id ='$user->id'
                       ";

            $db = static::getDB();
            $stmt = $db->prepare($sql);


            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            if ($stmt->fetchAll()) {

                $sql = "DELETE  FROM users_online where user_id ='$user->id'  ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

                $sql = "INSERT INTO  users_online(user_id,date) 
                        VALUES ( :user_id,:date) ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':user_id', $user->id, PDO::PARAM_STR);
                $stmt->bindValue(':date',$date->format('Y-m-d H-i-s'), PDO::PARAM_STR);


                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();

            }
            else{
                $sql = "INSERT INTO  users_online(user_id,date) 
                        VALUES ( :user_id,:date) ";

                $db = static::getDB();
                $stmt = $db->prepare($sql);

                $stmt->bindValue(':user_id', $user->id, PDO::PARAM_STR);
                $stmt->bindValue(':date',$date->format('Y-m-d H-i-s'), PDO::PARAM_STR);

                $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

                $stmt->execute();
            }
        
    }
}

   
    public function onlineUser()
    {
      date_default_timezone_set('Africa/Cairo');
  
        $date = date("Y-m-d H:i:s");
        $time = strtotime($date);
        $time = $time - (1 * 60);
        $date = date("Y-m-d H:i:s", $time); 
      
            $sql = "SELECT * FROM users_online where date > '$date' ";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();
            $count = $stmt->rowCount();
            $data = $stmt->fetchAll();

            $output = '';

            if ($data) {
                foreach ($data as &$row) {
                    $user = User::FindByID($row->user_id,'users');
                    $photo = '';
                    if(isset($user->personal_photo)) $photo = $user->personal_photo;
                      $name = '';
                    if(isset($user->name)) $name = $user->name;
                    $output .= '
                  <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                       
                            <img src="../' . $photo . '" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title" style="text-align: center">
                                   ' . $name . '
                                </h3>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ' . $row->date . '</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
             
                         ';
                }
            } else {
                $output .= '<a href="#" class="dropdown-item dropdown-footer">No users is online</a>';
            }


            $data = array(
                'online' => $output,
                'online_users' => $count
            );
            return $data;
        }





}
