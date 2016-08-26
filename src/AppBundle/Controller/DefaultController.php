<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, $username = null, $level = null)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $products = $repository->findByStatus('trending');
        $session = $request->getSession();
        if ($session->has('login'))
        {
            $isLogin = true;
            $login = $session->get('login');
            $username = $login->getUsername();
            $level = $login->getLevel();
        }
        else {
            $isLogin = false;
        }
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'products' => $products,
            'isLogin' => $isLogin,
            'username' => $username,
            'level' => $level,
        ]);
    }
}
