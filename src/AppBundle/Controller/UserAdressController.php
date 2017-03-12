<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\UserAdress;
use AppBundle\Form\UserAdressType;

/**
 * UserAdress controller.
 *
 * @Route("/useradress")
 */
class UserAdressController extends Controller
{
    /**
     * Lists all UserAdress entities.
     *
     * @Route("/", name="useradress_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userAdresses = $em->getRepository('AppBundle:UserAdress')->findAll();

        return $this->render('useradress/index.html.twig', array(
            'userAdresses' => $userAdresses,
        ));
    }

    /**
     * Creates a new UserAdress entity.
     *
     * @Route("/new", name="useradress_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userAdress = new UserAdress();
        $form = $this->createForm('AppBundle\Form\UserAdressType', $userAdress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userAdress);
            $em->flush();

            return $this->redirectToRoute('useradress_show', array('id' => $userAdress->getId()));
        }

        return $this->render('useradress/new.html.twig', array(
            'userAdress' => $userAdress,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserAdress entity.
     *
     * @Route("/{id}", name="useradress_show")
     * @Method("GET")
     */
    public function showAction(UserAdress $userAdress)
    {
        $deleteForm = $this->createDeleteForm($userAdress);

        return $this->render('useradress/show.html.twig', array(
            'userAdress' => $userAdress,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserAdress entity.
     *
     * @Route("/{id}/edit", name="useradress_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserAdress $userAdress)
    {
        $deleteForm = $this->createDeleteForm($userAdress);
        $editForm = $this->createForm('AppBundle\Form\UserAdressType', $userAdress);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userAdress);
            $em->flush();

            return $this->redirectToRoute('useradress_edit', array('id' => $userAdress->getId()));
        }

        return $this->render('useradress/edit.html.twig', array(
            'userAdress' => $userAdress,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserAdress entity.
     *
     * @Route("/{id}", name="useradress_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserAdress $userAdress)
    {
        $form = $this->createDeleteForm($userAdress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userAdress);
            $em->flush();
        }

        return $this->redirectToRoute('useradress_index');
    }

    /**
     * Creates a form to delete a UserAdress entity.
     *
     * @param UserAdress $userAdress The UserAdress entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserAdress $userAdress)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('useradress_delete', array('id' => $userAdress->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
