<?php

namespace App\CodeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller{
    public function loginAction(){
        if($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->redirect($this->generateUrl('app_code'));
        }

        $request = $this->getRequest();
        $session = $request->getSession();

        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }else{
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR):
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return $this->render('AppCodeBundle:Security:login.html.twig', array('error' => $error));
    }
}
