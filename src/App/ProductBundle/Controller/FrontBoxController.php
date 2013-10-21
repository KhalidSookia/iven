<?php

namespace App\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProductBundle\Entity\FrontBox;
use App\ProductBundle\Form\FrontBoxType;

/**
 * FrontBox controller.
 *
 * @Route("/frontbox")
 */
class FrontBoxController extends Controller
{

    /**
     * Lists all FrontBox entities.
     *
     * @Route("/", name="frontbox")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppProductBundle:FrontBox')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FrontBox entity.
     *
     * @Route("/", name="frontbox_create")
     * @Method("POST")
     * @Template("AppProductBundle:FrontBox:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FrontBox();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $entity->getImage()->upload();
            $em->flush();

            return $this->redirect($this->generateUrl('frontbox_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a FrontBox entity.
    *
    * @param FrontBox $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FrontBox $entity)
    {
        $form = $this->createForm(new FrontBoxType(), $entity, array(
            'action' => $this->generateUrl('frontbox_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FrontBox entity.
     *
     * @Route("/new", name="frontbox_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FrontBox();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FrontBox entity.
     *
     * @Route("/{id}", name="frontbox_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppProductBundle:FrontBox')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FrontBox entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FrontBox entity.
     *
     * @Route("/{id}/edit", name="frontbox_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppProductBundle:FrontBox')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FrontBox entity.');
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
    * Creates a form to edit a FrontBox entity.
    *
    * @param FrontBox $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FrontBox $entity)
    {
        $form = $this->createForm(new FrontBoxType(), $entity, array(
            'action' => $this->generateUrl('frontbox_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FrontBox entity.
     *
     * @Route("/{id}", name="frontbox_update")
     * @Method("PUT")
     * @Template("AppProductBundle:FrontBox:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppProductBundle:FrontBox')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FrontBox entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('frontbox_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FrontBox entity.
     *
     * @Route("/{id}", name="frontbox_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppProductBundle:FrontBox')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FrontBox entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('frontbox'));
    }

    /**
     * Creates a form to delete a FrontBox entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frontbox_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
