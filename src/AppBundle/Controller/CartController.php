<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\flowers;
use AppBundle\Entity\UserAdress;
use AppBundle\Entity\Vestigingen;
use AppBundle\Form\flowersType;

/**
 * Cart controller, using sessions
 *
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/", name="cart")
     */
    public function indexAction()
    {
        // get the cart from  the session
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        // $cart = $session->set('cart', '');
        $cart = $session->get('cart', array());

        // $cart = array_keys($cart);
        // print_r($cart); die;

        // fetch the information using query and ids in the cart
        if ($cart != '') {

            if (isset($cart)) {
                $em = $this->getDoctrine()->getEntityManager();
                $product = $em->getRepository('AppBundle:flowers')->findAll();
            } else {
                return $this->render('Cart/index.html.twig', array(
                    'empty' => true,
                ));
            }


            return $this->render('Cart/index.html.twig', array(
                'empty' => false,
                'product' => $product,
            ));
        } else {
            return $this->render('Cart/index.html.twig', array(
                'empty' => true,
            ));
        }
    }

    /**
     * @Route("/checkout", name="checkout")
     * @throws \LogicException
     */
    public function checkoutAction(Request $request)
    {
        // get the cart from  the session
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        // $cart = $session->set('cart', '');
        $cart = $session->get('cart', array());

        $auth_checker = $this->get('security.authorization_checker');
        if (!$auth_checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $userAdress = $em->getRepository('AppBundle:UserAdress')->findOneBy(array('userId' => $this->getUser()->getId()));
        // new UserAdress if no UserAdress found...
        if (!$userAdress) {
            $userAdress = new UserAdress();
            $userAdress->setUserId($this->getUser()->getId());
        }

        $form = $this->createForm('AppBundle\Form\UserAdressType', $userAdress);

        $form->get('user')->setData($this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userAdress);
            $em->flush();

            // mail the order.

            // empty cart. in session.

            return $this->redirectToRoute('start');
        }

        // fetch the information using query and ids in the cart
        if ($cart != '') {

            if (isset($cart)) {
                $em = $this->getDoctrine()->getManager();
                $product = $em->getRepository('AppBundle:flowers')->findAll();
                $vestiging = $em->getRepository('AppBundle:Vestigingen')->findAll();
                $useradress = $em->getRepository('AppBundle:UserAdress')->find($this->getUser()->getId());
            } else {
                return $this->render('Cart/checkout.html.twig', array(
                    'empty' => true,
                ));
            }

            //$form->remove('user');
            return $this->render('Cart/checkout.html.twig', array(
                'empty' => false,
                'product' => $product,
                'vestigingen' => $vestiging,
                'useradress' => $useradress,
                'form' => $form->createView(),
            ));
        } else {
            return $this->render('Cart/checkout.html.twig', array(
                'empty' => true,
            ));
        }
    }

    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function addAction($id)
    {
        // fetch the cart
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('AppBundle:flowers')->find($id);
        //print_r($product->getId()); die;
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $cart = $session->get('cart', array());

        // check if the $id already exists in it.
        if ($product == NULL) {
            $this->get('session')->setFlash('notice', 'This product is not     available in Stores');
            return $this->redirect($this->generateUrl('cart'));
        } else {
            if (isset($cart[$id])) {

                ++$cart[$id];
                /*  $qtyAvailable = $product->getQuantity();

                  if ($qtyAvailable >= $cart[$id]['quantity'] + 1) {
                      $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
                  } else {
                      $this->get('session')->setFlash('notice', 'Quantity     exceeds the available stock');
                      return $this->redirect($this->generateUrl('cart'));
                  } */
            } else {
                // if it doesnt make it 1
                $cart[$id] = 1;
                //$cart[$id]['quantity'] = 1;
            }

            $session->set('cart', $cart);
            //echo('<pre>');
            //print_r($cart); echo ('</pre>');die();
            return $this->redirect($this->generateUrl('cart'));

        }
    }

    /**
     * @Route("/remove/{id}", name="cart_remove")
     */
    public function removeAction($id)
    {
        // check the cart
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        $cart = $session->get('cart', array());

        // if it doesn't exist redirect to cart index page. end
        if(!$cart[$id]) { $this->redirect( $this->generateUrl('cart') ); }

        // check if the $id already exists in it.
        if( isset($cart[$id]) ) {
            $cart[$id] = $cart[$id] - 1;
            if ($cart[$id] < 1) {
                unset($cart[$id]);
            }
        } else {
            return $this->redirect( $this->generateUrl('cart') );
        }

        $session->set('cart', $cart);

        //echo('<pre>');
        //print_r($cart); echo ('</pre>');die();

        return $this->redirect( $this->generateUrl('cart') );
    }

    /**
     * @Route("/show", name="show")
     * @throws \LogicException
     */
    public function showAction(Request $request)
    {
        // get the cart from  the session
        $session = $this->get('request_stack')->getCurrentRequest()->getSession();
        // $cart = $session->set('cart', '');
        $cart = $session->get('cart', array());

        $auth_checker = $this->get('security.authorization_checker');
        if (!$auth_checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $em = $this->getDoctrine()->getManager();
        $userAdress = $em->getRepository('AppBundle:UserAdress')->findOneBy(array('userId' => $this->getUser()->getId()));
        // new UserAdress if no UserAdress found...
        if (!$userAdress) {
            $userAdress = new UserAdress();
            $userAdress->setUserId($this->getUser()->getId());
        }

        $form = $this->createForm('AppBundle\Form\UserAdressType', $userAdress);

        $form->get('user')->setData($this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userAdress);
            $em->flush();

            // mail the order.

            // empty cart. in session.

            return $this->redirectToRoute('start');
        }

        // fetch the information using query and ids in the cart
        if ($cart != '') {

            if (isset($cart)) {
                $em = $this->getDoctrine()->getManager();
                $product = $em->getRepository('AppBundle:flowers')->findAll();
                $vestiging = $em->getRepository('AppBundle:Vestigingen')->findAll();
                $useradress = $em->getRepository('AppBundle:UserAdress')->find($this->getUser()->getId());
            } else {
                return $this->render('Cart/show.html.twig', array(
                    'empty' => true,
                ));
            }

            //$form->remove('user');
            return $this->render('Cart/show.html.twig', array(
                'empty' => false,
                'product' => $product,
                'vestigingen' => $vestiging,
                'useradress' => $useradress,
                'form' => $form->createView(),
            ));
        } else {
            return $this->render('Cart/show.html.twig', array(
                'empty' => true,
            ));
        }
    }
   

   
}