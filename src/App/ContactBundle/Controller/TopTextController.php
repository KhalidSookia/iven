<?php

namespace App\ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\ContactBundle\Entity\TopText;
use App\ContactBundle\Form\TopTextType;

/**
 * TopText controller.
 *
 * @Route("/toptext")
 */
class TopTextController extends Controller
{

    /**
     * Lists all TopText entities.
     *
     * @Route("/", name="toptext")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppContactBundle:TopText')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TopText entity.
     *
     * @Route("/", name="toptext_create")
     * @Method("POST")
     * @Template("AppContactBundle:TopText:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TopText();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('toptext_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TopText entity.
    *
    * @param TopText $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TopText $entity)
    {
        $form = $this->createForm(new TopTextType(), $entity, array(
            'action' => $this->generateUrl('toptext_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TopText entity.
     *
     * @Route("/new", name="toptext_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TopText();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TopText entity.
     *
     * @Route("/{id}", name="toptext_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppContactBundle:TopText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TopText entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TopText entity.
     *
     * @Route("/{id}/edit", name="toptext_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppContactBundle:TopText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TopText entity.');
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
    * Creates a form to edit a TopText entity.
    *
    * @param TopText $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TopText $entity)
    {
        $form = $this->createForm(new TopTextType(), $entity, array(
            'action' => $this->generateUrl('toptext_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TopText entity.
     *
     * @Route("/{id}", name="toptext_update")
     * @Method("PUT")
     * @Template("AppContactBundle:TopText:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppContactBundle:TopText')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TopText entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('toptext_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TopText entity.
     *
     * @Route("/{id}", name="toptext_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppContactBundle:TopText')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TopText entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('toptext'));
    }

    /**
     * Creates a form to delete a TopText entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('toptext_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
