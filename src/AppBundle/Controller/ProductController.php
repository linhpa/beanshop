<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;

class ProductController extends Controller
{
	public function detailAction($productBrand)
	{
		$product = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneByBrand($productBrand);
		return $this->render('default/single.html.twig', array('product' => $product));
	}
}

?>