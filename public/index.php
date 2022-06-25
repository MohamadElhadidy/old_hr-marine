<?php

require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('job_applications/new', ['controller' => 'job_applications', 'action' => 'new']);
$router->add('job_applications/report', ['controller' => 'job_applications', 'action' => 'report']);
$router->add('job_applications/saveApplication', ['controller' => 'job_applications', 'action' => 'saveApplication']);
$router->add('job_applications/deleteJobApplication', ['controller' => 'job_applications', 'action' => 'deleteJobApplication']);
$router->add('job_applications/view', ['controller' => 'job_applications', 'action' => 'view']);
$router->add('job_applications/getJobApplication', ['controller' => 'job_applications', 'action' => 'getJobApplication']);
$router->add('job_applications/EditJobApplication', ['controller' => 'job_applications', 'action' => 'EditJobApplication']);
$router->add('job_applications/okJobApplication', ['controller' => 'job_applications', 'action' => 'okJobApplication']);




$router->add('work_places/new', ['controller' => 'work_places', 'action' => 'new']);
$router->add('work_places/saveWorkPlace', ['controller' => 'work_places', 'action' => 'saveWorkPlace']);
$router->add('work_places/report', ['controller' => 'work_places', 'action' => 'report']);
$router->add('work_places/view', ['controller' => 'work_places', 'action' => 'view']);
$router->add('work_places/editWorkPlace', ['controller' => 'work_places', 'action' => 'editWorkPlace']);
$router->add('work_places/deleteWorkPlace', ['controller' => 'work_places', 'action' => 'deleteWorkPlace']);
$router->add('work_places/getWorkPlace', ['controller' => 'work_places', 'action' => 'getWorkPlace']);
$router->add('drop/deleteDrop?{token:[\da-f]+}', ['controller' => 'drop', 'action' => 'deleteDrop']);


$router->add('Profile/my_profile', ['controller' => 'Profile', 'action' => 'my_profile']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'password', 'action' => 'reset']);
$router->add('Signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);





$router->add('{controller}/{action}');
    
$router->dispatch($_SERVER['QUERY_STRING']);

?>
