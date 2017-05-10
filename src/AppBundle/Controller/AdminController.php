<?php

namespace AppBundle\Controller;

use AppBundle\Constants\Constants;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        $userRoles = $user->getRoles();

        $isEditor = in_array(Constants::ROLE_EDITOR, $userRoles);
        $isAdmin = in_array(Constants::ROLE_ADMIN, $userRoles);

        return [
            'isEditor' => $isEditor,
            'isAdmin' => $isAdmin,
            'id' => $user->getId(),
            'page' => $page
        ];
    }


    /**
     * @Route("/permissions/add/{id}/{page}", name="add_permissions_process")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function setPermissionsProcessAction(Request $request, User $user, $page)
    {
        $userRoles = $user->getRoles();
        $isEditor = in_array(Constants::ROLE_EDITOR, $userRoles);
        $isAdmin = in_array(Constants::ROLE_ADMIN, $userRoles);

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            $userRoleAdmin = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => Constants::ROLE_ADMIN]);
            $userRoleEditor = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => Constants::ROLE_EDITOR]);

            if ($request->get('admin') == 'on') {
                if (! $isAdmin) {
                    $user->addRoles($userRoleAdmin);
                }
            } else {
                $user->removeRole($userRoleAdmin);
            }

            if ($request->get('editor') == 'on') {
                if (! $isEditor) {
                    $user->addRoles($userRoleEditor);
                }
            } else {
                $user->removeRole($userRoleEditor);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('add_permissions', ['id' => $user->getId(), 'page' => $page]);
        }


        return $this->render('@App/Admin/setPermissions.html.twig', [
            'isEditor' => $isEditor,
            'isAdmin' => $isAdmin,
            'id' => $user->getId(),
            'page' => $page
        ]);
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