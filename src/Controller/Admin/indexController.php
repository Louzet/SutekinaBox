<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class indexController extends AbstractController
{

    private $session;

    private $manager;

    private $package;

    /**
     * indexController constructor.
     * @param SessionInterface $session
     * @param ObjectManager $manager
     * @param Packages $package
     */
    public function __construct(SessionInterface $session, ObjectManager $manager, Packages $package)
    {
        $this->session = $session->get('session');
        $this->manager = $manager;
        $this->package = $package;
    }



    public function gestionMembres()
    {
        $repository = $this->manager->getRepository(UserRepository::class);
    }

    /**
     * @Route(
     *     "/admin/gestion-stocks",
     *     name="admin.gestion.stocks",
     *     methods={"GET"}
     * )
     * @Security("has_role('ROLE_GERANT')")
     */
    public function gestionStocks()
    {
        return new Response("stock");
    }


}