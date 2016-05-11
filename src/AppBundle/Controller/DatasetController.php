<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Dataset;
use AppBundle\Form\DatasetType;

/**
 * Dataset controller.
 *
 * @Route("/admin/dataset")
 */
class DatasetController extends Controller
{
    /**
     * Lists all Dataset entities.
     *
     * @Route("/", name="admin_dataset_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datasets = $em->getRepository('AppBundle:Dataset')->findAll();

        return $this->render('dataset/index.html.twig', array(
            'datasets' => $datasets,
        ));
    }

    /**
     * Creates a new Dataset entity.
     *
     * @Route("/new", name="admin_dataset_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dataset = new Dataset();
        $form = $this->createForm('AppBundle\Form\DatasetType', $dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataset);
            $em->flush();

            return $this->redirectToRoute('admin_dataset_show', array('id' => $dataset->getId()));
        }

        return $this->render('dataset/new.html.twig', array(
            'dataset' => $dataset,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Dataset entity.
     *
     * @Route("/{id}", name="admin_dataset_show")
     * @Method("GET")
     */
    public function showAction(Dataset $dataset)
    {
        $deleteForm = $this->createDeleteForm($dataset);

        return $this->render('dataset/show.html.twig', array(
            'dataset' => $dataset,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dataset entity.
     *
     * @Route("/{id}/edit", name="admin_dataset_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dataset $dataset)
    {
        $deleteForm = $this->createDeleteForm($dataset);
        $editForm = $this->createForm('AppBundle\Form\DatasetType', $dataset);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dataset);
            $em->flush();

            return $this->redirectToRoute('admin_dataset_edit', array('id' => $dataset->getId()));
        }

        return $this->render('dataset/edit.html.twig', array(
            'dataset' => $dataset,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dataset entity.
     *
     * @Route("/{id}", name="admin_dataset_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dataset $dataset)
    {
        $form = $this->createDeleteForm($dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dataset);
            $em->flush();
        }

        return $this->redirectToRoute('admin_dataset_index');
    }

    /**
     * Creates a form to delete a Dataset entity.
     *
     * @param Dataset $dataset The Dataset entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dataset $dataset)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_dataset_delete', array('id' => $dataset->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
