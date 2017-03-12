<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class defaultController extends controller
{
    /**
     * @Route("/", name = "start")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $flowers = $em->getRepository('AppBundle:flowers')->findAll();

        return $this->render(
            'default/default.html.twig',
            array(
                'flowers' => $flowers,
            )
        );
    }


    /**
     * @Route("/contact", _name="contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('49526@idcollege.nl')
                    ->setBody(
                        $this->renderView(
                            'StoreBundle:Mail:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'message' => $form->get('message')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');



                return $this->redirect($this->generateUrl('contact'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

}