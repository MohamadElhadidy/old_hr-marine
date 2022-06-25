<?php

namespace App\Controllers;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Errors extends \Core\Controller
{

    public function notFoundAction()
    {
       View::renderTemplate('Errors/404.html');
    }
}
