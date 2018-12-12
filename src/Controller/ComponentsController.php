<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComponentsController extends AbstractController
{

    public function sidenav()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $route = $this->get('request_stack')->getMasterRequest()->attributes->get('_route');

        return $this->render('_components/_sidenav.html.twig', [
            'user'     => $user,
            'route'    => $route
        ]);
    }

}