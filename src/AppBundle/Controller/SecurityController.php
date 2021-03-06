<?php

namespace AppBundle\Controller;

use AppBundle\Constants\Constants;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $token = $this->get('security.token_storage')->getToken();
        $user = $token->getUser();

        if ($user  != 'anon.') {
            return new RedirectResponse($this->generateUrl('all_products'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            'last_username' => $lastUsername,
            'error'         => $error
        ];
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/register", name="user_register")
     * @Template()
     * @param Request $request
     *
     */
    public function registerAction(Request $request)
    {
        $token = $this->get('security.token_storage')->getToken();
        $user = $token->getUser();

        if ($user  != Constants::ANONYMOUS) {
            return new RedirectResponse($this->generateUrl('all_products'));
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.password_encoder');

            $userRole = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => 'ROLE_USER']);
            $user->addRoles($userRole);
            $user->setVirtualCash(Constants::DEFAULT_VIRTUAL_CASH);
            $user->setIsBan(0);

            $user->setPassword(
                $encoder->encodePassword($user, $user->getPasswordRaw())
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            return $this->redirectToRoute('all_products');
        }

        return [
            'form' => $form->createView()
        ];
    }
}
