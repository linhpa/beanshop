<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;

class FilterController extends Controller {

	public function filterAction($productCategory)
	{
		$category = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneByDetail($productCategory);
		$products = $this->getDoctrine()->getRepository('AppBundle:Product')->findByCategoryId($category->getId());
		return $this->render('default/product.html.twig', [
			'products' => $products,
			'category' => $category,
			]);
	}
}

?>