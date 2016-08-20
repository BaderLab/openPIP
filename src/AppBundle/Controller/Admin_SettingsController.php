<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Admin_Settings;
use AppBundle\Form\Admin_SettingsType;

/**
 * Admin_Settings controller.
 *
 * @Route("/admin_settings")
 */
class Admin_SettingsController extends Controller
{
    /**
     * Lists all Admin_Settings entities.
     *
     * @Route("/", name="admin_settings_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $admin_Settings = $em->getRepository('AppBundle:Admin_Settings')->findAll();

        return $this->render('admin_settings/index.html.twig', array(
            'admin_Settings' => $admin_Settings,
        ));
    }

    /**
     * Creates a new Admin_Settings entity.
     *
     * @Route("/new", name="admin_settings_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $admin_Setting = new Admin_Settings();
        $form = $this->createForm('AppBundle\Form\Admin_SettingsType', $admin_Setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin_Setting);
            $em->flush();

            return $this->redirectToRoute('admin_settings_show', array('id' => $admin_Setting->getId()));
        }

        return $this->render('admin_settings/new.html.twig', array(
            'admin_Setting' => $admin_Setting,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Admin_Settings entity.
     *
     * @Route("/{id}", name="admin_settings_show")
     * @Method("GET")
     */
    public function showAction(Admin_Settings $admin_Setting)
    {
        $deleteForm = $this->createDeleteForm($admin_Setting);

        return $this->render('admin_settings/show.html.twig', array(
            'admin_Setting' => $admin_Setting,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Admin_Settings entity.
     *
     * @Route("/{id}/edit", name="admin_settings_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Admin_Settings $admin_Setting)
    {
        $deleteForm = $this->createDeleteForm($admin_Setting);
        $editForm = $this->createForm('AppBundle\Form\Admin_SettingsType', $admin_Setting);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin_Setting);
            $em->flush();

            return $this->redirectToRoute('admin_settings_edit', array('id' => $admin_Setting->getId()));
        }

        return $this->render('admin_settings/edit.html.twig', array(
            'admin_Setting' => $admin_Setting,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Admin_Settings entity.
     *
     * @Route("/{id}", name="admin_settings_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Admin_Settings $admin_Setting)
    {
        $form = $this->createDeleteForm($admin_Setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($admin_Setting);
            $em->flush();
        }

        return $this->redirectToRoute('admin_settings_index');
    }

    /**
     * Creates a form to delete a Admin_Settings entity.
     *
     * @param Admin_Settings $admin_Setting The Admin_Settings entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Admin_Settings $admin_Setting)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_settings_delete', array('id' => $admin_Setting->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
