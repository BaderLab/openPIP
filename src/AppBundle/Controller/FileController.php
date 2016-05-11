<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\File;
use AppBundle\Form\FileType;

/**
 * File controller.
 *
 * @Route("/admin/file")
 */
class FileController extends Controller
{
    /**
     * Lists all File entities.
     *
     * @Route("/", name="admin_file_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $files = $em->getRepository('AppBundle:File')->findAll();

        return $this->render('file/index.html.twig', array(
            'files' => $files,
        ));
    }

    /**
     * Creates a new File entity.
     *
     * @Route("/new", name="admin_file_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $file = new File();
        $form = $this->createForm('AppBundle\Form\FileType', $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            return $this->redirectToRoute('admin_file_show', array('id' => $file->getId()));
        }

        return $this->render('file/new.html.twig', array(
            'file' => $file,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a File entity.
     *
     * @Route("/{id}", name="admin_file_show")
     * @Method("GET")
     */
    public function showAction(File $file)
    {
        $deleteForm = $this->createDeleteForm($file);

        return $this->render('file/show.html.twig', array(
            'file' => $file,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing File entity.
     *
     * @Route("/{id}/edit", name="admin_file_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, File $file)
    {
        $deleteForm = $this->createDeleteForm($file);
        $editForm = $this->createForm('AppBundle\Form\FileType', $file);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            return $this->redirectToRoute('admin_file_edit', array('id' => $file->getId()));
        }

        return $this->render('file/edit.html.twig', array(
            'file' => $file,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a File entity.
     *
     * @Route("/{id}", name="admin_file_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, File $file)
    {
        $form = $this->createDeleteForm($file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();
        }

        return $this->redirectToRoute('admin_file_index');
    }

    /**
     * Creates a form to delete a File entity.
     *
     * @param File $file The File entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(File $file)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_file_delete', array('id' => $file->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
