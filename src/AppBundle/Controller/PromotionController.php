<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Product;
use AppBundle\Entity\Promotions;
use AppBundle\Entity\User;
use AppBundle\Form\PromotionsForOneCategoryType;
use AppBundle\Form\PromotionsForOneProductType;
use AppBundle\Form\PromotionsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PromotionController extends Controller
{
    /**
     * @Route("/promotions/view/{page}", name="all_promotions")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function viewAllPromotionsAction($page = 1)
    {
        $promotion = $this->get('app.promotion_service');
        $promotion->refreshPromotions();
        $promotion->setPromotions();

        $pagination = $this->get('app.pagination');
        $pagination->setLimit(5);

        $securityContext = $this->get('security.authorization_checker');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $promotions = $pagination->getAllPromotions($page);

        } elseif ($securityContext->isGranted('ROLE_EDITOR')) {
            $promotions = $pagination->getAllPromotionsEditor($page);
        } else {
            /** @var User $user */
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $userId = $user->getId();

            $promotions = $pagination->getAllPromotionsUser($page, $userId);
        }

        $maxPages = ceil($promotions->count() / $pagination->getLimit());
        $thisPage = $page;

        return [
            'promotions' => $promotions,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ];
    }

    /**
     * @Route("/promotion/delete/{id}/{page}", name="delete_promotion")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function deletePromotionAction(Promotions $promotion, $page)
    {
        $promotionService = $this->get('app.promotion_service');
        $promotionService->remove($promotion);

        $this->addFlash('success', 'Successfully remove promotion');
        return $this->redirectToRoute('all_promotions', ['page' => $page]);
    }

    /**
     * @Route("/promotion/add/all", name="add_promotion_all_products")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function addPromotionForAllProductsAction()
    {
        $form = $this->createForm(PromotionsType::class);

        return [
            'promotionForm' => $form->createView()
        ];
    }

    /**
     * @Route("/promotion/add/all", name="add_promotion_all_products_process")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function addPromotionForAllProductsProcessAction(Request $request)
    {
        $promotion = new Promotions();
        $form = $this->createForm(PromotionsType::class, $promotion);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $startDate = $promotion->getDateFrom()->format('Y-m-d H:i:s');
            $endDate = $promotion->getDateTo()->format('Y-m-d H:i:s');

            if ($startDate > $endDate) {
                $this->addFlash('error', 'Set correct dates');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $percentages = $promotion->getPercentages();

            if ((int) $percentages < 0 || (int) $percentages > 100) {
                $this->addFlash('error', 'Set correct percentages');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $promotionName = $promotion->getPromotionName();
            $findProduct = $this->getDoctrine()->getRepository(Promotions::class)->findBy(['promotionName' => $promotionName]);

            if ($findProduct) {
                $this->addFlash('error', 'Change Promotion Name, already exist');
                return $this->redirectToRoute('add_promotion_all_products');
            }


            $user = null;

            $securityContext = $this->get('security.authorization_checker');

            if (! $securityContext->isGranted('ROLE_EDITOR') && ! $securityContext->isGranted('ROLE_ADMIN') && $securityContext->isGranted('ROLE_USER')) {
                $user = $this->get('security.token_storage')->getToken()->getUser();
            }

            $promotion->setUserId($user);
            $promotion->setFullPromotion(true);

            $entityManager->persist($promotion);
            $entityManager->flush();

            $this->addFlash('success', 'Successfully add promotion!');
            return $this->redirectToRoute('all_promotions');
        }

        return $this->render('@App/Promotion/addPromotionForAllProducts.html.twig', [
            'promotionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/promotion/add/by/product", name="add_promotion_one_products")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function addPromotionForOneProductsAction()
    {
        $form = $this->createForm(PromotionsForOneProductType::class, null, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        return [
            'promotionForm' => $form->createView()
        ];
    }


    /**
     * @Route("/promotion/add/by/product", name="add_promotion_one_products_process")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function addPromotionForOneProductsProcessAction(Request $request)
    {

        $promotion = new Promotions();
        $form = $this->createForm(PromotionsForOneProductType::class, $promotion, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $productId = $promotion->getProduct();

            $product = $this->getDoctrine()->getRepository(Product::class)->find($productId);

            if (empty($product)) {
                $this->addFlash('error', 'Not found this product');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $startDate = $promotion->getDateFrom()->format('Y-m-d H:i:s');
            $endDate = $promotion->getDateTo()->format('Y-m-d H:i:s');

            if ($startDate > $endDate) {
                $this->addFlash('error', 'Set correct dates');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $percentages = $promotion->getPercentages();

            if ((int) $percentages < 0 || (int) $percentages > 100) {
                $this->addFlash('error', 'Set correct percentages');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $promotionName = $promotion->getPromotionName();
            $findProduct = $this->getDoctrine()->getRepository(Promotions::class)->findBy(['promotionName' => $promotionName]);

            if ($findProduct) {
                $this->addFlash('error', 'Change Promotion Name, already exist');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $user = null;

            $securityContext = $this->get('security.authorization_checker');

            if (! $securityContext->isGranted('ROLE_EDITOR') && ! $securityContext->isGranted('ROLE_ADMIN') && $securityContext->isGranted('ROLE_USER')) {
                $user = $this->get('security.token_storage')->getToken()->getUser();
            }

            $promotion->setUserId($user);
            $promotion->setProduct($product);

            $entityManager->persist($promotion);
            $entityManager->flush();

            $this->addFlash('success', 'Successfully add promotion!');
            return $this->redirectToRoute('all_promotions');
        }

        return $this->render('@App/Promotion/addPromotionForAllProducts.html.twig', [
            'promotionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/promotion/add/by/category", name="add_promotion_one_category")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function addPromotionForOneCategoryAction()
    {
        $form = $this->createForm(PromotionsForOneCategoryType::class, null, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        return [
            'promotionForm' => $form->createView()
        ];
    }

    /**
     * @Route("/promotion/add/by/category", name="add_promotion_one_category_process")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function addPromotionForOneCategoryProcessAction(Request $request)
    {

        $promotion = new Promotions();
        $form = $this->createForm(PromotionsForOneCategoryType::class, $promotion, [
            'entity_manager' => $this->get('doctrine.orm.entity_manager')
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $categoryId = $promotion->getCategory();

            $category = $this->getDoctrine()->getRepository(Categories::class)->find($categoryId);

            if (empty($category)) {
                $this->addFlash('error', 'Not found this category');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $startDate = $promotion->getDateFrom()->format('Y-m-d H:i:s');
            $endDate = $promotion->getDateTo()->format('Y-m-d H:i:s');

            if ($startDate > $endDate) {
                $this->addFlash('error', 'Set correct dates');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $percentages = $promotion->getPercentages();

            if ((int) $percentages < 0 || (int) $percentages > 100) {
                $this->addFlash('error', 'Set correct percentages');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $promotionName = $promotion->getPromotionName();
            $findProduct = $this->getDoctrine()->getRepository(Promotions::class)->findBy(['promotionName' => $promotionName]);

            if ($findProduct) {
                $this->addFlash('error', 'Change Promotion Name, already exist');
                return $this->redirectToRoute('add_promotion_all_products');
            }

            $user = null;

            $securityContext = $this->get('security.authorization_checker');

            if (! $securityContext->isGranted('ROLE_EDITOR') && ! $securityContext->isGranted('ROLE_ADMIN') && $securityContext->isGranted('ROLE_USER')) {
                $user = $this->get('security.token_storage')->getToken()->getUser();
            }

            $promotion->setUserId($user);
            $promotion->setCategory($category);

            $entityManager->persist($promotion);
            $entityManager->flush();

            $this->addFlash('success', 'Successfully add promotion!');
            return $this->redirectToRoute('all_promotions');
        }

        return $this->render('@App/Promotion/addPromotionForAllProducts.html.twig', [
            'promotionForm' => $form->createView()
        ]);
    }
}
