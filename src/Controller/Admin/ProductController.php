<?php

namespace App\Controller\Admin;

use App\Controller\SlugifyTrait;
use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    use SlugifyTrait;

    private $manager;

    private $packages;

    /**
     * ProductController constructor.
     * @param ObjectManager $manager
     * @param Packages $packages
     */
    public function __construct(ObjectManager $manager, Packages $packages)
    {
        $this->manager = $manager;

        $this->packages = $packages;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/gestion-stocks",
     *     name="admin.gestion.stock",
     *     methods={"GET"})
     */
    public function gestionStock()
    {
        /*if(!$this->getUser()){
            #Si l'utilisateur est déjà connecté, on le redirige
            return $this->redirectToRoute('admin.connect');
        }*/

        $products = $this->manager->getRepository(Product::class)->findAll();

        dump($products);
        dump($this->getParameter('images_assets_dir'));

        return $this->render("admin/index.html.twig", [
            'products'  => $products,
            'package'   => $this->packages
        ]);
    }

}