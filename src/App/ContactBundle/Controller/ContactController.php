<?php

namespace App\ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ContactBundle\Entity\Contact;
use App\ContactBundle\Form\ContactType;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="contact")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppContactBundle:Contact')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Contact entity.
     *
     * @Route("/", name="contact_create")
     * @Method("POST")
     * @Template("AppContactBundle:Contact:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Contact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);




        if ($form->isValid()) {



            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

             $message = \Swift_Message::newInstance()
            ->setSubject('Contact from Iven')
            ->setFrom('no-reply@iven-invest.com')
            ->setTo('contact@iven-invest.com')
            ->setBody("Un nouveau contact a été fait sur IVEN.");
            
            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('info', 'Votre message a bien été envoyé.');


            return $this->redirect($this->generateUrl('app_app_homepage'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Contact entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Contact $entity)
    {
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('contact_create'),
            'method' => 'POST',
        ));


        $form->add('submit', 'submit', array('label' => 'Envoyer', 'attr' => array('class' => 'submit_btn float_l')));

        $form->add('reset', 'reset', array('label' => 'Reset', 'attr' => array('class' => 'submit_btn float_r')));

        return $form;
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contact();
        $form   = $this->createCreateForm($entity);
        $entity->setCreatedAt(new \Datetime);
        $em = $this->getDoctrine()->getManager();
        $topText = $em->getRepository('AppContactBundle:TopText')->findBy(
            array(
                'active' => true
            ));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'topTexts' => $topText,
        );
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppContactBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }


        return array(
            'entity'      => $entity,
        );
    }
}
