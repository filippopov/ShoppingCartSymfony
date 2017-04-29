<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Exceptions\QuantityExceededException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CartController extends Controller
{
    /**
     * @Route("/show-cart", name="show_cart")
     * @Template()
     */
    public function showCartAction()
    {
        $basket = $this->get('app.basket');
        $basket->refresh();
    }

    /**
     * @Route("/cart-add/{slug}/{quantity}", name="cart_add")
     */
    public function add(string $slug, int $quantity)
    {
        $basket = $this->get('app.basket');

        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['slug' => $slug]);

        if (! $product) {
            return new RedirectResponse($this->generateUrl('all_products'));
        }

        try {
            $basket->add($product, $quantity);

            $this->addFlash("success", "Product {$product->getTitle()}, successfully add in your cart!");
        } catch (QuantityExceededException $e) {
            $this->addFlash("error", "Product {$product->getTitle()}, no enough quantity");

            return $this->redirectToRoute("get_product", ['slug' => $slug]);
        }

        return new RedirectResponse($this->generateUrl('show_cart'));
    }
}
