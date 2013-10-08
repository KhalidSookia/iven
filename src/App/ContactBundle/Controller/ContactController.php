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

        $entity->setCreatedAt(new \Datetime);

        if ($form->isValid()) {



            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contact_show', array('id' => $entity->getId())));
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

        $form->add('submit', 'submit', array('label' => 'Envoyer'));

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

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
