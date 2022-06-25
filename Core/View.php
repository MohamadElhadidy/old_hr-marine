<?php

namespace Core;

/**
 * View
 *
 * PHP version 7.0
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
          echo static::getTemplate($template, $args);
    }
    public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {

            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('current_user',\App\Auth::getUser());
            $twig->addGlobal('user_types',\App\Auth::getUserTypes());
            $twig->addGlobal('companies',\App\Auth::companies());
            $twig->addGlobal('flash_messages',\App\flash::getMessage());
            $twig->addGlobal('users',\App\Auth::getAllUsers());
            $twig->addGlobal('usersN',\App\Auth::getAllUserForN());
            $twig->addGlobal('user',\App\Auth::getUsers());
            $twig->addGlobal('company',\App\Auth::getCompany());
            $twig->addGlobal('getCompaniesPermission',\App\Auth::getCompaniesPermission());
            $twig->addGlobal('getPermission',\App\Auth::getPermission());
            $twig->addGlobal('governorates',\App\Auth::governorates());
            $twig->addGlobal('cities',\App\Auth::cities());
            $twig->addGlobal('employees',\App\Auth::employees());
            $twig->addGlobal('armyEmployees',\App\Auth::armyEmployees());
            $twig->addGlobal('pensionEmployees',\App\Auth::pensionEmployees());
            $twig->addGlobal('jobApplications',\App\Auth::jobApplications());
            $twig->addGlobal('armyStatus',\App\Auth::armyStatus());
            $twig->addGlobal('job_statuss',\App\Auth::jobStatus());
            $twig->addGlobal('maritalStatus',\App\Auth::maritalStatus());
            $twig->addGlobal('qualificationType',\App\Auth::qualificationType());
            $twig->addGlobal('departments',\App\Auth::departments());
            $twig->addGlobal('jobs',\App\Auth::jobs());
            $twig->addGlobal('work_places',\App\Auth::work_places());
            $twig->addGlobal('holidays',\App\Auth::holidays());
            $twig->addGlobal('holidayType',\App\Auth::holidayType());
            $twig->addGlobal('penalties',\App\Auth::penalties());
            $twig->addGlobal('penaltyType',\App\Auth::penaltyType());
            $twig->addGlobal('insurances',\App\Auth::insurances());
            $twig->addGlobal('insuranceType',\App\Auth::insuranceType());
            $twig->addGlobal('drops',\App\Auth::drops());
            $twig->addGlobal('fingerprints',\App\Auth::fingerprints());
            $twig->addGlobal('templates',\App\Auth::templates());
            $twig->addGlobal('salaries',\App\Auth::salaries());
            $twig->addGlobal('stats',\App\Auth::stats());
            $twig->addGlobal('notifications',\App\Auth::notifications());















        }

        return $twig->render($template, $args);
    }
}
