<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Master_Table;
use AppBundle\Form\Master_TableType;

/**
 * Master_Table controller.
 *
 * @Route("/admin/master_table")
 */
class Master_TableController extends Controller
{
    /**
     * Lists all Master_Table entities.
     *
     * @Route("/", name="admin_master_table_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $master_Tables = $em->getRepository('AppBundle:Master_Table')->findAll();

        return $this->render('master_table/index.html.twig', array(
            'master_Tables' => $master_Tables,
        ));
    }

    /**
     * Creates a new Master_Table entity.
     *
     * @Route("/new", name="admin_master_table_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $master_Table = new Master_Table();
        $form = $this->createForm('AppBundle\Form\Master_TableType', $master_Table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($master_Table);
            $em->flush();

            return $this->redirectToRoute('admin_master_table_show', array('id' => $master_Table->getId()));
        }

        return $this->render('master_table/new.html.twig', array(
            'master_Table' => $master_Table,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Master_Table entity.
     *
     * @Route("/{id}", name="admin_master_table_show")
     * @Method("GET")
     */
    public function showAction(Master_Table $master_Table)
    {
        $deleteForm = $this->createDeleteForm($master_Table);

        return $this->render('master_table/show.html.twig', array(
            'master_Table' => $master_Table,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Master_Table entity.
     *
     * @Route("/{id}/edit", name="admin_master_table_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Master_Table $master_Table)
    {
        $deleteForm = $this->createDeleteForm($master_Table);
        $editForm = $this->createForm('AppBundle\Form\Master_TableType', $master_Table);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($master_Table);
            $em->flush();

            return $this->redirectToRoute('admin_master_table_edit', array('id' => $master_Table->getId()));
        }

        return $this->render('master_table/edit.html.twig', array(
            'master_Table' => $master_Table,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Master_Table entity.
     *
     * @Route("/{id}", name="admin_master_table_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Master_Table $master_Table)
    {
        $form = $this->createDeleteForm($master_Table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($master_Table);
            $em->flush();
        }

        return $this->redirectToRoute('admin_master_table_index');
    }

    /**
     * Creates a form to delete a Master_Table entity.
     *
     * @param Master_Table $master_Table The Master_Table entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Master_Table $master_Table)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_master_table_delete', array('id' => $master_Table->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
