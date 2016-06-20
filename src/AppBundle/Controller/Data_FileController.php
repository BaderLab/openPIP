<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Data_File;
use AppBundle\Form\Data_FileType;

/**
 * Data_File controller.
 *
 * @Route("/admin/data_file")
 */
class Data_FileController extends Controller
{
    /**
     * Lists all Data_File entities.
     *
     * @Route("/", name="admin_data_file_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data_Files = $em->getRepository('AppBundle:Data_File')->findAll();

        return $this->render('data_file/index.html.twig', array(
            'data_Files' => $data_Files,
        ));
    }

    /**
     * Creates a new Data_File entity.
     *
     * @Route("/new", name="admin_data_file_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data_File = new Data_File();
        $form = $this->createForm('AppBundle\Form\Data_FileType', $data_File);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data_File);
            $em->flush();

            return $this->redirectToRoute('admin_data_file_show', array('id' => $data_File->getId()));
        }

        return $this->render('data_file/new.html.twig', array(
            'data_File' => $data_File,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Data_File entity.
     *
     * @Route("/{id}", name="admin_data_file_show")
     * @Method("GET")
     */
    public function showAction(Data_File $data_File)
    {
        $deleteForm = $this->createDeleteForm($data_File);

        return $this->render('data_file/show.html.twig', array(
            'data_File' => $data_File,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Data_File entity.
     *
     * @Route("/{id}/edit", name="admin_data_file_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Data_File $data_File)
    {
        $deleteForm = $this->createDeleteForm($data_File);
        $editForm = $this->createForm('AppBundle\Form\Data_FileType', $data_File);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data_File);
            $em->flush();

            return $this->redirectToRoute('admin_data_file_edit', array('id' => $data_File->getId()));
        }

        return $this->render('data_file/edit.html.twig', array(
            'data_File' => $data_File,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Data_File entity.
     *
     * @Route("/{id}", name="admin_data_file_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Data_File $data_File)
    {
        $form = $this->createDeleteForm($data_File);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($data_File);
            $em->flush();
        }

        return $this->redirectToRoute('admin_data_file_index');
    }

    /**
     * Creates a form to delete a Data_File entity.
     *
     * @param Data_File $data_File The Data_File entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Data_File $data_File)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_data_file_delete', array('id' => $data_File->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
