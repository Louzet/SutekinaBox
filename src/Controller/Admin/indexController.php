<?php

namespace App\Controller\Admin;

use App\Form\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class indexController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin",
     *     name="admin.index",
     *     methods={"GET"})
     *
     */
    public function index()
    {
        return $this->render("admin/index.html.twig");
    }

    /**
     * @Route("/connect",
     *     name="admin.connect",
     *     methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils, Request $request)
    {

        if($this->getUser()){
            return $this->redirectToRoute("admin.index", [], Response::HTTP_MOVED_PERMANENTLY);
        }
        $form = $this->createForm(UserLoginType::class, [
            "username" => $authenticationUtils->getLastUsername()
        ]);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render("admin/connect.html.twig", [
            "form"   => $form->createView(),
            "error"  => $error
        ]);

    }

    /**
     * @Route("/logout",
     *     name="admin.logout",
     *     methods={"GET"})
     */
    public function logout()
    {

    }

}