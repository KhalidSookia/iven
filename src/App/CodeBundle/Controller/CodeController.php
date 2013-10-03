<?php

namespace App\CodeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\CodeBundle\Entity\Code;
use App\CodeBundle\Form\CodeType;

/**
 * Code controller.
 *
 * @Route("/code")
 */
class CodeController extends Controller
{

    /**
     * Lists all Code entities.
     *
     * @Route("/", name="code")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppCodeBundle:Code')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Code entity.
     *
     * @Route("/", name="code_create")
     * @Method("POST")
     * @Template("AppCodeBundle:Code:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Code();

        $entity->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        $entity->setRoles(array());
        $entity->setCreatedAt(new \Datetime);
        $entity->setFirstAccessAt(new \Datetime);

        $saveCode = uniqid();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('code_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Code entity.
    *
    * @param Code $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Code $entity)
    {
        $form = $this->createForm(new CodeType(), $entity, array(
            'action' => $this->generateUrl('code_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Code entity.
     *
     * @Route("/new", name="code_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Code();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Code entity.
     *
     * @Route("/{id}", name="code_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppCodeBundle:Code')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Code entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Code entity.
     *
     * @Route("/{id}/edit", name="code_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppCodeBundle:Code')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Code entity.');
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
    * Creates a form to edit a Code entity.
    *
    * @param Code $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Code $entity)
    {
        $form = $this->createForm(new CodeType(), $entity, array(
            'action' => $this->generateUrl('code_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Code entity.
     *
     * @Route("/{id}", name="code_update")
     * @Method("PUT")
     * @Template("AppCodeBundle:Code:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppCodeBundle:Code')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Code entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('code_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Code entity.
     *
     * @Route("/{id}", name="code_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppCodeBundle:Code')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Code entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('code'));
    }

    /**
     * Creates a form to delete a Code entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('code_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
