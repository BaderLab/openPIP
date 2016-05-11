<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Protein;
use AppBundle\Form\ProteinType;

/**
 * Protein controller.
 *
 * @Route("/admin/protein")
 */
class ProteinController extends Controller
{
    /**
     * Lists all Protein entities.
     *
     * @Route("/", name="admin_protein_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proteins = $em->getRepository('AppBundle:Protein')->findAll();

        return $this->render('protein/index.html.twig', array(
            'proteins' => $proteins,
        ));
    }

    /**
     * Creates a new Protein entity.
     *
     * @Route("/new", name="admin_protein_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $protein = new Protein();
        $form = $this->createForm('AppBundle\Form\ProteinType', $protein);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($protein);
            $em->flush();

            return $this->redirectToRoute('admin_protein_show', array('id' => $protein->getId()));
        }

        return $this->render('protein/new.html.twig', array(
            'protein' => $protein,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Protein entity.
     *
     * @Route("/{id}", name="admin_protein_show")
     * @Method("GET")
     */
    public function showAction(Protein $protein)
    {
        $deleteForm = $this->createDeleteForm($protein);

        return $this->render('protein/show.html.twig', array(
            'protein' => $protein,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Protein entity.
     *
     * @Route("/{id}/edit", name="admin_protein_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Protein $protein)
    {
        $deleteForm = $this->createDeleteForm($protein);
        $editForm = $this->createForm('AppBundle\Form\ProteinType', $protein);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($protein);
            $em->flush();

            return $this->redirectToRoute('admin_protein_edit', array('id' => $protein->getId()));
        }

        return $this->render('protein/edit.html.twig', array(
            'protein' => $protein,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Protein entity.
     *
     * @Route("/{id}", name="admin_protein_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Protein $protein)
    {
        $form = $this->createDeleteForm($protein);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($protein);
            $em->flush();
        }

        return $this->redirectToRoute('admin_protein_index');
    }

    /**
     * Creates a form to delete a Protein entity.
     *
     * @param Protein $protein The Protein entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Protein $protein)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_protein_delete', array('id' => $protein->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
