<?php

namespace App\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frontBox = $em->getRepository('AppProductBundle:FrontBox')->findBy(
            array('active' => true));

        $frontBottomR = $em->getRepository('AppProductBundle:FrontBottom')->findBy(
            array(
                'active' => true,
                'rl' => true
                ));

        $frontBottomL = $em->getRepository('AppProductBundle:FrontBottom')->findBy(
            array(
                'active' => true,
                'rl' => false
                ));

        $slider = $em->getRepository('AppProductBundle:slider')->findBy(
            array(
                'active' => true,
                ));

        return $this->render('AppAppBundle:App:index.html.twig', array(
            'frontBoxs' => $frontBox,
            'frontBottomsR' => $frontBottomR,
            'frontBottomsL' => $frontBottomL,
            'sliders' => $slider
            ));
    }

    public function bodyAction($slug){
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('AppProductBundle:Product')->findBy(
            array('active' => true, 'slug' => $slug));

        if (!$product) {
            throw $this->createNotFoundException('Unable to find Product product.');
        }

        return $this->render('AppAppBundle:Product:index.html.twig', array('products' => $product));
    }

    public function adminAction(){
        return $this->render('AppAppBundle:Admin:admin.html.twig');
    }
}
