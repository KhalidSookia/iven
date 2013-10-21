<?php

namespace App\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ProductBundle\Entity\FrontBottom;
use App\ProductBundle\Form\FrontBottomType;

/**
 * FrontBottom controller.
 *
 * @Route("/frontbottom")
 */
class FrontBottomController extends Controller
{

    /**
     * Lists all FrontBottom entities.
     *
     * @Route("/", name="frontbottom")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppProductBundle:FrontBottom')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FrontBottom entity.
     *
     * @Route("/", name="frontbottom_create")
     * @Method("POST")
     * @Template("AppProductBundle:FrontBottom:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FrontBottom();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('frontbottom_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a FrontBottom entity.
    *
    * @param FrontBottom $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FrontBottom $entity)
    {
        $form = $this->createForm(new FrontBottomType(), $entity, array(
            'action' => $this->generateUrl('frontbottom_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FrontBottom entity.
     *
     * @Route("/new", name="frontbottom_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FrontBottom();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FrontBottom entity.
     *
     * @Route("/{id}", name="frontbottom_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppProductBundle:FrontBottom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FrontBottom entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FrontBottom entity.
     *
     * @Route("/{id}/edit", name="frontbottom_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppProductBundle:FrontBottom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FrontBottom entity.');
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
    * Creates a form to edit a FrontBottom entity.
    *
    * @param FrontBottom $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FrontBottom $entity)
    {
        $form = $this->createForm(new FrontBottomType(), $entity, array(
            'action' => $this->generateUrl('frontbottom_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FrontBottom entity.
     *
     * @Route("/{id}", name="frontbottom_update")
     * @Method("PUT")
     * @Template("AppProductBundle:FrontBottom:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppProductBundle:FrontBottom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FrontBottom entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('frontbottom_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FrontBottom entity.
     *
     * @Route("/{id}", name="frontbottom_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppProductBundle:FrontBottom')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FrontBottom entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('frontbottom'));
    }

    /**
     * Creates a form to delete a FrontBottom entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frontbottom_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
