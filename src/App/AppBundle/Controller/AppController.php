<?php

namespace App\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppAppBundle:App:index.html.twig', array());
    }

    public function authenticatedAction(){
        return $this->render('AppAppBundle:Authenticated:index.html.twig', array());
    }
}
