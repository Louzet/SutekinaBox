<?php

namespace App\Controller\Admin\Security;


use App\Form\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $session;

    /**
     * indexController constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session->get('session');
    }

    /**
     * @Route("/admin-connect",
     *     name="admin.connect",
     *     methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils, Request $request)
    {
        if($this->getUser()){
            #Si l'utilisateur est déjà connecté, on le redirige
            return $this->redirectToRoute('admin.gestion.commandes');
        }

        $form = $this->createForm(UserLoginType::class, [
            "username" => $authenticationUtils->getLastUsername()
        ])->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render("admin/connect.html.twig", [
            "form"   => $form->createView(),
            "error"  => $error
        ]);

    }

    /**
     * @Route("/admin-logout",
     *     name="admin.logout",
     *     methods={"GET"})
     */
    public function logout()
    {

    }

}