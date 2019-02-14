<?php

namespace PlantsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public  function addsuserAction()
    {
        return $this->render('@Plants/template/inscription.html.twig');
    }
}
