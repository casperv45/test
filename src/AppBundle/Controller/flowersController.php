<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\flowers;
use AppBundle\Form\flowersType;

/**
 * flowers controller.
 *
 * @Route("/flowers")
 */
class flowersController extends Controller
{
    /**
     * Lists all flowers entities.
     *
     * @Route("/", name="flowers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $flowers = $em->getRepository('AppBundle:flowers')->findAll();

        return $this->render('flowers/index.html.twig', array(
            'flowers' => $flowers,
        ));
    }

    /**
     * Creates a new flowers entity.
     *
     * @Route("/new", name="flowers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $flower = new flowers();
        $form = $this->createForm('AppBundle\Form\flowersType', $flower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $flower->upload();

            $em->persist($flower);
            $em->flush();

            return $this->redirectToRoute('flowers_show', array('id' => $flower->getId()));
        }

        return $this->render('flowers/new.html.twig', array(
            'flower' => $flower,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a flowers entity.
     *
     * @Route("/{id}", name="flowers_show")
     * @Method("GET")
     */
    public function showAction(flowers $flower)
    {
        $deleteForm = $this->createDeleteForm($flower);

        return $this->render('flowers/show.html.twig', array(
            'flower' => $flower,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing flowers entity.
     *
     * @Route("/{id}/edit", name="flowers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, flowers $flower)
    {
        $deleteForm = $this->createDeleteForm($flower);
        $editForm = $this->createForm('AppBundle\Form\flowersType', $flower);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $flower->upload();

            $em->persist($flower);
            $em->flush();

            return $this->redirectToRoute('flowers_edit', array('id' => $flower->getId()));
        }

        return $this->render('flowers/edit.html.twig', array(
            'flower' => $flower,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a flowers entity.
     *
     * @Route("/{id}", name="flowers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, flowers $flower)
    {
        $form = $this->createDeleteForm($flower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($flower);
            $em->flush();
        }

        return $this->redirectToRoute('flowers_index');
    }

    /**
     * Creates a form to delete a flowers entity.
     *
     * @param flowers $flower The flowers entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(flowers $flower)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flowers_delete', array('id' => $flower->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
