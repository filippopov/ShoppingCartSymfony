<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Form\ProductType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Category;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/home/{page}", name="all_products")
     * @Method("GET")
     * @Template()
     */
    public function viewAllProductsAction($page = 1)
    {
        $pagination = $this->get('app.pagination');
        $pagination->setLimit(6);
        $products = $pagination->getAllNotDeletedProducts($page);

        $maxPages = ceil($products->count() / $pagination->getLimit());
        $thisPage = $page;

        return [
            'products' => $products,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ];
    }


    /**
     * @Route("/products/by/category/{category}/{page}", name="products_by_category")
     * @Method("GET")
     * @Template()
     */
    public function viewProductsByCategoryAction($category = 0, $page = 1)
    {
        if (! $category) {
            return $this->redirectToRoute('all_products');
        }

        $pagination = $this->get('app.pagination');
        $pagination->setLimit(6);
        $products = $pagination->getAllNotDeletedProductsByCategory($category, $page);

        $maxPages = ceil($products->count() / $pagination->getLimit());
        $thisPage = $page;

        return [
            'products' => $products,
            'category' => $category,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
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
     * @Security("has_role('ROLE_USER')")
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

    /**
     * @Route("/products/add", name="add_product_process")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function addProductProcessAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $dateTimeNow = new \DateTime('now');
            $product->setCreatedAt($dateTimeNow);
            $product->setUpdatedAt($dateTimeNow);

            $title = $product->getTitle();

            $findTitle = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['title' => $title]);

            if ($findTitle) {
                $this->addFlash('error', 'Product with this title already exist. Please change title');
                return $this->redirectToRoute('add_product');
            }

            $slug = strtolower($title);
            $slug = str_replace(' ', '-', $slug);

            $findSlug = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['slug' => $slug]);

            if ($findSlug) {
                $this->addFlash('error', 'Product with this slug already exist. Please change title');
                return $this->redirectToRoute('add_product');
            }

            $product->setSlug($slug);

            $user = null;

            $securityContext = $this->get('security.authorization_checker');

            if (! $securityContext->isGranted('ROLE_EDITOR') && ! $securityContext->isGranted('ROLE_ADMIN') && $securityContext->isGranted('ROLE_USER')) {
                $user = $this->get('security.token_storage')->getToken()->getUser();
            }

            $product->setUser($user);

            $categoryId = $product->getCategory();

            $category = $this->getDoctrine()->getRepository(Categories::class)->find($categoryId);

            $product->setCategory($category);

            /** @var UploadedFile $file */
            $file = $product->getImage();

            if ($file) {
                $type = $file->getMimeType();

                $fileName = md5($product->getTitle() . '' . $dateTimeNow->format('Y-m-d H:i:s'));

                $extensionArray = [
                    "image/png" => 'png',
                    "image/jpeg" => 'jpg',
                    "image/jpg" => 'jpg'
                ];

                $extension = isset($extensionArray[$type]) ? $extensionArray[$type] : '';

                if ($extension) {
                    $fileName = $fileName . '.' . $extension;
                }

                $file->move(
                    $this->get('kernel')->getRootDir() . '/../web/images/',
                    $fileName
                );

                $product->setImage($fileName);
            } else {
                $product->setImage('Product11.png');
            }

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', "Product with name {$product->getTitle()} was added successfully");

            return $this->redirectToRoute('all_products_edit_menu');
        }

        return $this->render('@App/Product/addProduct.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/products/edit/menu/{page}", name="all_products_edit_menu")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function viewAllProductsEditMenuAction($page = 1)
    {
        $pagination = $this->get('app.pagination');
        $pagination->setLimit(5);

        $securityContext = $this->get('security.authorization_checker');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $products = $pagination->getAllProducts($page);
        } elseif ($securityContext->isGranted('ROLE_EDITOR')) {
            $products = $pagination->getAllProductsEditor($page);
        } else {
            /** @var User $user */
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();

            $products = $pagination->getAllProductsUser($page, $userId);
        }

        $maxPages = ceil($products->count() / $pagination->getLimit());
        $thisPage = $page;

        return [
            'products' => $products,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ];
    }

    /**
     * @Route("/products/edit/{id}/{page}", name="edit_product")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function editProductAction(Product $product, $page)
    {
        $form = $this->createForm(ProductType::class, $product, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        return [
            'productForm' => $form->createView()
        ];
    }

    /**
     * @Route("/products/edit/{id}/{page}", name="edit_product_process")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function editProductProcessAction(Product $product, $page, Request $request)
    {
        $form = $this->createForm(ProductType::class, $product, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $dateTimeNow = new \DateTime('now');
            $product->setUpdatedAt($dateTimeNow);

            $title = $product->getTitle();

            $findTitle = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['title' => $title]);

            if ($findTitle) {
                $this->addFlash('error', 'Product with this title already exist. Please change title');
                return $this->redirectToRoute('edit_product');
            }

            $slug = strtolower($title);
            $slug = str_replace(' ', '-', $slug);

            $findSlug = $this->getDoctrine()->getRepository(Product::class)->findOneBy(['slug' => $slug]);

            if ($findSlug) {
                $this->addFlash('error', 'Product with this slug already exist. Please change title');
                return $this->redirectToRoute('edit_product');
            }

            $product->setSlug($slug);

            $categoryId = $product->getCategory();

            $category = $this->getDoctrine()->getRepository(Categories::class)->find($categoryId);

            if (! $category) {
                $this->addFlash('error', 'Invalid Category');
                return $this->redirectToRoute('edit_product');
            }

            $product->setCategory($category);

            /** @var UploadedFile $file */
            $file = $product->getImage();

            if ($file) {
                $type = $file->getMimeType();

                $fileName = md5($product->getTitle() . '' . $dateTimeNow->format('Y-m-d H:i:s'));

                $extensionArray = [
                    "image/png" => 'png',
                    "image/jpeg" => 'jpg',
                    "image/jpg" => 'jpg'
                ];

                $extension = isset($extensionArray[$type]) ? $extensionArray[$type] : '';

                if ($extension) {
                    $fileName = $fileName . '.' . $extension;
                }

                $file->move(
                    $this->get('kernel')->getRootDir() . '/../web/images/',
                    $fileName
                );

                $product->setImage($fileName);
            } else {
                $product->setImage('Product11.png');
            }

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', "Product with name {$product->getTitle()} was edited successfully");

            return $this->redirectToRoute('all_products_edit_menu', ['page' => $page]);
        }

        return $this->render('@App/Product/editProduct.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/products/delete/{id}/{page}", name="delete_product")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function deleteProductAction(Product $product, $page)
    {
        $entityManger = $this->getDoctrine()->getManager();
        $dateTime = new \DateTime('now');

        $product->setDeletedAt($dateTime);
        $entityManger->persist($product);
        $entityManger->flush();

        $this->addFlash('success', 'Successfully mark this product as deleted');
        return $this->redirectToRoute('all_products_edit_menu', ['page' => $page]);
    }

    /**
     * @Route("/products/reverse/delete/{id}/{page}", name="reverse_delete_product")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function reverseDeleteProductAction(Product $product, $page)
    {
        $entityManger = $this->getDoctrine()->getManager();

        $product->setDeletedAt(null);
        $entityManger->persist($product);
        $entityManger->flush();

        $this->addFlash('success', 'Successfully reverse product delete');
        return $this->redirectToRoute('all_products_edit_menu', ['page' => $page]);
    }
}