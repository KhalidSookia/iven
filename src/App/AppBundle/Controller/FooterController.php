<?php

namespace App\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\AppBundle\Entity\Footer;
use App\AppBundle\Form\FooterType;

/**
 * Footer controller.
 *
 * @Route("/footer")
 */
class FooterController extends Controller
{

    /**
     * Lists all Footer entities.
     *
     * @Route("/", name="footer")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppAppBundle:Footer')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Footer entity.
     *
     * @Route("/", name="footer_create")
     * @Method("POST")
     * @Template("AppAppBundle:Footer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Footer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $entity->setCreatedAt(new \Datetime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('footer_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Footer entity.
    *
    * @param Footer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Footer $entity)
    {
        $form = $this->createForm(new FooterType(), $entity, array(
            'action' => $this->generateUrl('footer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Footer entity.
     *
     * @Route("/new", name="footer_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Footer();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Footer entity.
     *
     * @Route("/{id}", name="footer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppAppBundle:Footer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Footer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Footer entity.
     *
     * @Route("/{id}/edit", name="footer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppAppBundle:Footer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Footer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Footer entity.
    *
    * @param Footer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Footer $entity)
    {
        $form = $this->createForm(new FooterType(), $entity, array(
            'action' => $this->generateUrl('footer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Footer entity.
     *
     * @Route("/{id}", name="footer_update")
     * @Method("PUT")
     * @Template("AppAppBundle:Footer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppAppBundle:Footer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Footer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('footer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Footer entity.
     *
     * @Route("/{id}", name="footer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppAppBundle:Footer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Footer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('footer'));
    }

    /**
     * Creates a form to delete a Footer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('footer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function footerAction(){
        $em = $this->getDoctrine()->getManager();
        $footers = $em->getRepository('AppAppBundle:Footer')->findBy(
            array('active' => true));

        return $this->render('AppAppBundle:Footer:footer.html.twig', array('footers' => $footers));
    }
}
