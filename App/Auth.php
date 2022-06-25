<?php


namespace App;

use App\Controllers\Account;
use App\Controllers\departments;
use App\Models\employess;
use App\Models\User;
use App\Models\RememberedLogin;
use Core\Controller;


class Auth
{
public  static function login($user,$remember_me)
{
    session_regenerate_id(true);

    $_SESSION['hr'] = $user->id;
    $remember_me = true;
    if($remember_me){
        if($user->rememberLogin()){
            setcookie('remember_me',$user->remember_token,$user->expiry_timestamp,'/');
        }
    }
}

public static function logout()
{
// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie('remember_me', '', time() - 42000,
$params["path"], $params["domain"],
$params["secure"], $params["httponly"]
);
setcookie('company', '', time() - 42000,
$params["path"], $params["domain"],
$params["secure"], $params["httponly"]
);
}

// Finally, destroy the session.
session_destroy();
static::forgetLogin();
}
public static function companyLogout()
{

setcookie('company', '', time() - 42000);
}
public static function rememberRequestedPage()
{
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
}
public static function getReturnToPage()
{
        return $_SESSION['return_to'] ?? Controller::redirect('Dashboard\index');
}
    public static function getUser()
    {
        if(isset($_SESSION['hr'])){
            return User::FindByID($_SESSION['hr']);
        }
        else{
            return static::loginFromRememberCookie();
        }
    }
    protected  static function loginFromRememberCookie()
    {
        $cookie =$_COOKIE['remember_me'] ?? false;
        if ($cookie){
            $remembered_login =RememberedLogin::findByToken($cookie);
            if($remembered_login && ! $remembered_login->hasExpired()){
            $user =$remembered_login->getUser();
            static::login($user,false);
            return $user;
            }
        }
    }
    protected static function forgetLogin()
    {
        $cookie =$_COOKIE['remember_me'] ?? false;
        if ($cookie){
            $remembered_login =RememberedLogin::findByToken($cookie);
            if($remembered_login){
                $user =$remembered_login->delete();
            }
        }
        setcookie('remember_me','',time() - 3600);
        setcookie('company','',time() - 3600);
    }
    public static function getAllUsers()
    {
        return User::getAllUser();
    }
    public static function getAllUserForN()
    {
        return User::getAllUserForN();
    }
    public static function getUsers()
    {
        return User::getUsers();
    }
    public static function getCompaniesPermission()
    {
        return User::getCompaniesPermission();
    }
    public static function getPermission()
    {
        return User::getPermission();
    }

    public static function getUserTypes()
    {
        return User::getUserTypes();
    }
    public static function companies()
    {
        return employess::companies();
    }


    public static function cities()
    {
        return employess::getAllCites();
    }
    public static function governorates(){
        return employess::getGovernorates();
    }


    public static function employees(){
        return employess::getEmployees();
    }
    
    public static function armyEmployees(){
        return employess::getِArmyEmployees();
    }
    
     public static function pensionEmployees(){
        return employess::getPensionEmployees();
    }
    public static function jobApplications(){
        return employess::getJobApplications();
    }

    public static function armyStatus(){
        return employess::getArmyStatus();
    }
    public static function maritalStatus(){
        return employess::getMaritalStatus();
    }
    public static function qualificationType(){
        return employess::getQualificationType();
    }

    public static function departments(){
        return employess::getDepartments();
    }
    public static function jobs(){
        return employess::getJobs();
    }
    public static function jobStatus(){
        return employess::getJobStatus();
    }
     public static function work_places(){
        return employess::getWorkPlaces();
    }
    public static function holidays(){
        return employess::getHolidays();
    }
    public static function holidayType(){
        return employess::getHolidayType();
    }
    public static function penalties(){
        return employess::getPenalties();
    }
    public static function penaltyType(){
        return employess::getPenaltyType();
    }
    public static function insurances(){
        return employess::getInsurances();
    }
    public static function insuranceType(){
        return employess::getInsuranceType();
    }
    public static function drops(){
        return employess::getDrops();
    }
    public static function templates(){
        return employess::getTemplates();
    }
    public static function salaries(){
        return employess::getSalaries();
    }
    public static function stats(){
        return employess::stats();
    }
    
        public static function fingerprints(){
        return employess::fingerprints();
    }

    public static function notifications(){
        return employess::getNotifications();
    }

    public static function url()
    {

        $url = "http://";
        // Append the host(domain name, ip) to the URL.
        $url.= $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL
        $url.= $_SERVER['REQUEST_URI'];
        return $url;
    }

public static function param()
{
    $url = Auth::url();
    $param1 = explode('?',$url);
    return explode('&',urldecode($param1[1]));
}




    public  static function company($id)
    {
        session_regenerate_id(true);

        $_SESSION['company'] = $id;
        setcookie('company', $id, time() + (60*60*24*365), "/"); //  365 day

    }
    public  static function getCompany()
    {
       if (isset($_COOKIE['company'])){
          return  employess::findById($_COOKIE['company'],'companies');
       }

    }
  


}