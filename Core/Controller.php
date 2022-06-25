<?php

namespace Core;
use \App\Auth;
use \App\flash;
use App\Models\User;
use  \core\View;
/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
             header('location: http://'.$_SERVER['HTTP_HOST'].'/hr/public/Errors/notFound',TRUE, 303);
            exit;
           // throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }
    public  static function redirect($url)
    {
        header('location: http://'.$_SERVER['HTTP_HOST'].'/hr/public/'.$url,TRUE, 303);
        exit;
    }
    public static function redirectRequestUrl($url)
    {
    header('location: http://'.$_SERVER['HTTP_HOST'].$url,TRUE, 303);
    exit;
    }
    public static function requireLogin()
    {
        if(! Auth::getUser())
        {
            flash::addMessage("'سجل دخولك أولا'",flash::INFO);
            Auth::rememberRequestedPage();
            self::redirect('Login/new');
        }
        else{
            return true;
        }
    }
    public static function requireCompany()
    {
        $user = Auth::getUser();
        if ($user->auth == '4'){
            return true;
        }else {
            if (isset($_COOKIE['company'])) {
                if ($_COOKIE['company'] == '0') {
                    flash::addMessage("'اختر الشركة أولا'", flash::INFO);
                    self::redirect('Companies/new');
                }else{
                    return true;
                }
            }
            else{
                    flash::addMessage("'اختر الشركة أولا'", flash::INFO);
                    self::redirect('Companies/new');
            }
        }
    }
    public static function requireCompanyName()
    {
        $user = User::requireCompany();
        if ($user){
            return true;
        }else {
                flash::addMessage("'لا يوجد لديك الصلاحية'", flash::INFO);
                self::redirect('Companies/new');
        }
    }


}
