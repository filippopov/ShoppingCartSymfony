<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Product;
use AppBundle\Form\CategoriesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Route("/categories/all/{page}", name="all_categories")
     * @Security("has_role('ROLE_EDITOR') or has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function viewAllCategoriesAction($page = 1)
    {
        $pagination = $this->get('app.pagination');
        $pagination->setLimit(5);

        $categories = $pagination->getAllCategories($page);

        $maxPages = ceil($categories->count() / $pagination->getLimit());
        $thisPage = $page;

        return [
            'categories' => $categories,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ];
    }

    /**
     * @Route("/categories/delete/{id}/{page}", name="delete_category")
     * @Security("has_role('ROLE_EDITOR') or has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function deleteCategoryAction(Categories $category, $page)
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findBy(['category' => $category]);
        if ($products) {
            $this->addFlash('error', 'Remove all products from this category, if you wont to delete this category!');
            return $this->redirectToRoute('all_categories', ['page' => $page]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', 'Successfully deleted category');
        return $this->redirectToRoute('all_categories', ['page' => $page]);
    }

    /**
     * @Route("/categories/edit/{id}/{page}", name="edit_category")
     * @Security("has_role('ROLE_EDITOR') or has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editCategoryAction(Categories $category, $page)
    {
        $form = $this->createForm(CategoriesType::class, $category);

        return [
            'categoryForm' => $form->createView()
        ];
    }

    /**
     * @Route("/categories/edit/{id}/{page}", name="edit_category_process")
     * @Security("has_role('ROLE_EDITOR') or has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function editCategoryProcessAction(Categories $category, $page, Request $request)
    {
        $form = $this->createForm(CategoriesType::class, $category);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Successfully edit category');
            return $this->redirectToRoute('all_categories', ['page' => $page]);
        }

        return $this->render('@App/Category/editCategory.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/categories/add", name="add_category")
     * @Security("has_role('ROLE_EDITOR') or has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function addCategoryAction()
    {
        $form = $this->createForm(CategoriesType::class);

        return [
            'categoryForm' => $form->createView()
        ];
    }

    /**
     * @Route("/categories/add", name="add_category_process")
     * @Security("has_role('ROLE_EDITOR') or has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function addCategoryProcessAction(Request $request)
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Successfully add category');
            return $this->redirectToRoute('all_categories');
        }

        return $this->render('@App/Category/addCategory.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }
}