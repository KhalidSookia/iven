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

    public function bodyAction($slug){
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AppProductBundle:Product')->findBySlug($slug);

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product product.');
        }

        return $this->render('AppAppBundle:Product:index.html.twig', array('products' => $product));
    }
}
