<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/", name="all_products")
     * @Method("GET")
     * @Template()
     */
    public function viewAllProductsAction()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findBy([], ['title' => 'desc']);

        return [
            'products' => $products
        ];
    }
}


///**
// * @Route("/products", name="all_products")
// *
// * @return Response
// */
//public function viewAll()
//{
////        $products = array_filter($this->getDoctrine()
////            ->getRepository(Product::class)
////            ->findBy([], ['price'=>'asc', 'name' => 'asc']),
////        function(Product $product) {
////            return $product->getPrice() > 18;
////        });
//
//    $products = $this->getDoctrine()
//        ->getRepository(Product::class)
//        ->findBy([], ['price'=>'asc', 'name' => 'asc']);
//
//    return $this->render(
//        'products/view_all.html.twig',
//        [
//            'products' => $products
//        ]
//    );
//}