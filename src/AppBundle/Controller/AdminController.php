<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/users/all/{page}", name="all_users")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function viewAllUsersAction($page = 1)
    {
        $pagination = $this->get('app.pagination');
        $pagination->setLimit(5);

        $users = $pagination->getAllUsers($page);

        $maxPages = ceil($users->count() / $pagination->getLimit());
        $thisPage = $page;

        return [
            'users' => $users,
            'maxPages' => $maxPages,
            'thisPage' => $thisPage
        ];
    }

    /**
     * @Route("/permissions/add/{id}/{page}", name="add_permissions")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function setPermissionsAction(User $user, $page)
    {

    }


    /**
     * @Route("/user/ban/{id}/{page}", name="ban_user")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function banUserAction(User $user, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user->setIsBan(true);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Successfully ban user');
        return $this->redirectToRoute('all_users', ['page' => $page]);
    }

    /**
     * @Route("/user/reverse/ban/{id}/{page}", name="reverse_user_ban")
     * @Security("has_role('ROLE_USER')")
     * @Method("POST")
     */
    public function reverseUserBanAction(User $user, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user->setIsBan(false);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Successfully reverse ban');
        return $this->redirectToRoute('all_users', ['page' => $page]);
    }
}