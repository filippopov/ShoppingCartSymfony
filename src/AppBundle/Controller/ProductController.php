<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    /**
     * @Route("/product/{slug}", name="get_product")
     * @Method("GET")
     * @Template()
     */
    public function viewOneProductAction(string $slug)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['slug' => $slug]);

        if (! $product) {
            return $this->redirectToRoute('all_products');
        }

        $stock = $this->get('app.check_stock');
        $stock->setStock($product->getStock());

        return [
            'product' => $product,
            'stock' => $stock
        ];
    }


    /**
     * @Route("/products/add", name="add_product")
     * @Method("GET")
     * @Template()
     */
    public function addProductAction()
    {

        $form = $this->createForm(ProductType::class, null, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        return [
            'productForm' => $form->createView()
        ];
    }
}


