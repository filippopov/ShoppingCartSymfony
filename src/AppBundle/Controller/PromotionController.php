<?php

namespace AppBundle\Controller;

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
        return $this->redirectToRoute('all_products');
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
}
