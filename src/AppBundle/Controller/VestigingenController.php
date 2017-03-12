<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Vestigingen;
use AppBundle\Form\VestigingenType;

/**
 * Vestigingen controller.
 *
 * @Route("/vestigingen")
 */
class VestigingenController extends Controller
{
    /**
     * Lists all Vestigingen entities.
     *
     * @Route("/", name="vestigingen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vestigingens = $em->getRepository('AppBundle:Vestigingen')->findAll();

        return $this->render('vestigingen/index.html.twig', array(
            'vestigingens' => $vestigingens,
        ));
    }

    /**
     * Creates a new Vestigingen entity.
     *
     * @Route("/new", name="vestigingen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vestigingen = new Vestigingen();
        $form = $this->createForm('AppBundle\Form\VestigingenType', $vestigingen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vestigingen);
            $em->flush();

            return $this->redirectToRoute('vestigingen_show', array('id' => $vestigingen->getId()));
        }

        return $this->render('vestigingen/new.html.twig', array(
            'vestigingen' => $vestigingen,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Vestigingen entity.
     *
     * @Route("/{id}", name="vestigingen_show")
     * @Method("GET")
     */
    public function showAction(Vestigingen $vestigingen)
    {
        $deleteForm = $this->createDeleteForm($vestigingen);

        return $this->render('vestigingen/show.html.twig', array(
            'vestigingen' => $vestigingen,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Vestigingen entity.
     *
     * @Route("/{id}/edit", name="vestigingen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Vestigingen $vestigingen)
    {
        $deleteForm = $this->createDeleteForm($vestigingen);
        $editForm = $this->createForm('AppBundle\Form\VestigingenType', $vestigingen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vestigingen);
            $em->flush();

            return $this->redirectToRoute('vestigingen_edit', array('id' => $vestigingen->getId()));
        }

        return $this->render('vestigingen/edit.html.twig', array(
            'vestigingen' => $vestigingen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Vestigingen entity.
     *
     * @Route("/{id}", name="vestigingen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Vestigingen $vestigingen)
    {
        $form = $this->createDeleteForm($vestigingen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vestigingen);
            $em->flush();
        }

        return $this->redirectToRoute('vestigingen_index');
    }

    /**
     * Creates a form to delete a Vestigingen entity.
     *
     * @param Vestigingen $vestigingen The Vestigingen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vestigingen $vestigingen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vestigingen_delete', array('id' => $vestigingen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
