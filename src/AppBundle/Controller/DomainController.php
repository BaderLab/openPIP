<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Domain;
use AppBundle\Form\DomainType;

/**
 * Domain controller.
 *
 * @Route("/admin/domain")
 */
class DomainController extends Controller
{
    /**
     * Lists all Domain entities.
     *
     * @Route("/", name="admin_domain_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $domains = $em->getRepository('AppBundle:Domain')->findAll();

        return $this->render('domain/index.html.twig', array(
            'domains' => $domains,
        ));
    }

    /**
     * Creates a new Domain entity.
     *
     * @Route("/new", name="admin_domain_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $domain = new Domain();
        $form = $this->createForm('AppBundle\Form\DomainType', $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($domain);
            $em->flush();

            return $this->redirectToRoute('admin_domain_show', array('id' => $domain->getId()));
        }

        return $this->render('domain/new.html.twig', array(
            'domain' => $domain,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Domain entity.
     *
     * @Route("/{id}", name="admin_domain_show")
     * @Method("GET")
     */
    public function showAction(Domain $domain)
    {
        $deleteForm = $this->createDeleteForm($domain);

        return $this->render('domain/show.html.twig', array(
            'domain' => $domain,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Domain entity.
     *
     * @Route("/{id}/edit", name="admin_domain_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Domain $domain)
    {
        $deleteForm = $this->createDeleteForm($domain);
        $editForm = $this->createForm('AppBundle\Form\DomainType', $domain);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($domain);
            $em->flush();

            return $this->redirectToRoute('admin_domain_edit', array('id' => $domain->getId()));
        }

        return $this->render('domain/edit.html.twig', array(
            'domain' => $domain,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Domain entity.
     *
     * @Route("/{id}", name="admin_domain_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Domain $domain)
    {
        $form = $this->createDeleteForm($domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($domain);
            $em->flush();
        }

        return $this->redirectToRoute('admin_domain_index');
    }

    /**
     * Creates a form to delete a Domain entity.
     *
     * @param Domain $domain The Domain entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Domain $domain)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_domain_delete', array('id' => $domain->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
