<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Organism;
use AppBundle\Form\OrganismType;

/**
 * Organism controller.
 *
 * @Route("/admin/organism")
 */
class OrganismController extends Controller
{
    /**
     * Lists all Organism entities.
     *
     * @Route("/", name="admin_organism_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organisms = $em->getRepository('AppBundle:Organism')->findAll();

        return $this->render('organism/index.html.twig', array(
            'organisms' => $organisms,
        ));
    }

    /**
     * Creates a new Organism entity.
     *
     * @Route("/new", name="admin_organism_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $organism = new Organism();
        $form = $this->createForm('AppBundle\Form\OrganismType', $organism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organism);
            $em->flush();

            return $this->redirectToRoute('admin_organism_show', array('id' => $organism->getId()));
        }

        return $this->render('organism/new.html.twig', array(
            'organism' => $organism,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Organism entity.
     *
     * @Route("/{id}", name="admin_organism_show")
     * @Method("GET")
     */
    public function showAction(Organism $organism)
    {
        $deleteForm = $this->createDeleteForm($organism);

        return $this->render('organism/show.html.twig', array(
            'organism' => $organism,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Organism entity.
     *
     * @Route("/{id}/edit", name="admin_organism_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Organism $organism)
    {
        $deleteForm = $this->createDeleteForm($organism);
        $editForm = $this->createForm('AppBundle\Form\OrganismType', $organism);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organism);
            $em->flush();

            return $this->redirectToRoute('admin_organism_edit', array('id' => $organism->getId()));
        }

        return $this->render('organism/edit.html.twig', array(
            'organism' => $organism,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Organism entity.
     *
     * @Route("/{id}", name="admin_organism_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Organism $organism)
    {
        $form = $this->createDeleteForm($organism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organism);
            $em->flush();
        }

        return $this->redirectToRoute('admin_organism_index');
    }

    /**
     * Creates a form to delete a Organism entity.
     *
     * @param Organism $organism The Organism entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Organism $organism)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_organism_delete', array('id' => $organism->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
