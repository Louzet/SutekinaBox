<?php

namespace App\Controller\Admin\Commande;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/admin/commande-create",
     *     name="admin.gestion.commande.create")
     */
    public function createCommande()
    {

    }

    /**
     * @Route("/admin/commande-list",
     *     name="admin.gestion.commande")
     */
    public function listCommande()
    {
        $productEpuise = $this->productRepository->findProductSpent();

        return $this->render("commande/commande-list.html.twig", [
            'products'  => $productEpuise
        ]);
    }

}