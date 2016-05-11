<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Support_Information;
use AppBundle\Form\Support_InformationType;

/**
 * Support_Information controller.
 *
 * @Route("/admin/support_information")
 */
class Support_InformationController extends Controller
{
    /**
     * Lists all Support_Information entities.
     *
     * @Route("/", name="admin_support_information_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $support_Informations = $em->getRepository('AppBundle:Support_Information')->findAll();

        return $this->render('support_information/index.html.twig', array(
            'support_Informations' => $support_Informations,
        ));
    }

    /**
     * Creates a new Support_Information entity.
     *
     * @Route("/new", name="admin_support_information_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $support_Information = new Support_Information();
        $form = $this->createForm('AppBundle\Form\Support_InformationType', $support_Information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($support_Information);
            $em->flush();

            return $this->redirectToRoute('admin_support_information_show', array('id' => $support_Information->getId()));
        }

        return $this->render('support_information/new.html.twig', array(
            'support_Information' => $support_Information,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Support_Information entity.
     *
     * @Route("/{id}", name="admin_support_information_show")
     * @Method("GET")
     */
    public function showAction(Support_Information $support_Information)
    {
        $deleteForm = $this->createDeleteForm($support_Information);

        return $this->render('support_information/show.html.twig', array(
            'support_Information' => $support_Information,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Support_Information entity.
     *
     * @Route("/{id}/edit", name="admin_support_information_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Support_Information $support_Information)
    {
        $deleteForm = $this->createDeleteForm($support_Information);
        $editForm = $this->createForm('AppBundle\Form\Support_InformationType', $support_Information);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($support_Information);
            $em->flush();

            return $this->redirectToRoute('admin_support_information_edit', array('id' => $support_Information->getId()));
        }

        return $this->render('support_information/edit.html.twig', array(
            'support_Information' => $support_Information,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Support_Information entity.
     *
     * @Route("/{id}", name="admin_support_information_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Support_Information $support_Information)
    {
        $form = $this->createDeleteForm($support_Information);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($support_Information);
            $em->flush();
        }

        return $this->redirectToRoute('admin_support_information_index');
    }

    /**
     * Creates a form to delete a Support_Information entity.
     *
     * @param Support_Information $support_Information The Support_Information entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Support_Information $support_Information)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_support_information_delete', array('id' => $support_Information->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
