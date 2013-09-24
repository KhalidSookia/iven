<?php

namespace App\MenuBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AppMenuBundle:Default:index.html.twig', array('name' => $name));
    }
}
