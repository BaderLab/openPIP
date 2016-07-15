<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Interaction;
use AppBundle\Form\InteractionType;

/**
 * Interaction controller.
 *
 * @Route("/interaction")
 */
class InteractionController extends Controller
{
    /**
     * Lists all Interaction entities.
     *
     * @Route("/", name="interaction_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interactions = $em->getRepository('AppBundle:Interaction')->findAll();

        return $this->render('interaction/index.html.twig', array(
            'interactions' => $interactions,
        ));
    }

    /**
     * Creates a new Interaction entity.
     *
     * @Route("/new", name="interaction_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $interaction = new Interaction();
        $form = $this->createForm('AppBundle\Form\InteractionType', $interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interaction);
            $em->flush();

            return $this->redirectToRoute('interaction_show', array('id' => $interaction->getId()));
        }

        return $this->render('interaction/new.html.twig', array(
            'interaction' => $interaction,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Interaction entity.
     *
     * @Route("/{id}", name="interaction_show")
     * @Method("GET")
     */
    public function showAction(Interaction $interaction)
    {
        $deleteForm = $this->createDeleteForm($interaction);

        return $this->render('interaction/show.html.twig', array(
            'interaction' => $interaction,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Interaction entity.
     *
     * @Route("/{id}/edit", name="interaction_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Interaction $interaction)
    {
        $deleteForm = $this->createDeleteForm($interaction);
        $editForm = $this->createForm('AppBundle\Form\InteractionType', $interaction);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($interaction);
            $em->flush();

            return $this->redirectToRoute('interaction_edit', array('id' => $interaction->getId()));
        }

        return $this->render('interaction/edit.html.twig', array(
            'interaction' => $interaction,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Interaction entity.
     *
     * @Route("/{id}", name="interaction_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Interaction $interaction)
    {
        $form = $this->createDeleteForm($interaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($interaction);
            $em->flush();
        }

        return $this->redirectToRoute('interaction_index');
    }

    /**
     * Creates a form to delete a Interaction entity.
     *
     * @param Interaction $interaction The Interaction entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Interaction $interaction)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('interaction_delete', array('id' => $interaction->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
