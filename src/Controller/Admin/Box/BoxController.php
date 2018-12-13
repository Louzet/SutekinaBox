<?php

namespace App\Controller\Admin\Box;

use App\Entity\Box;
use App\Form\BoxCreationType;
use App\Repository\BoxRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BoxController extends AbstractController
{
    private $em;

    private $boxRepository;

    private $imageDirectory;

    public function __construct(ObjectManager $manager, BoxRepository $boxRepository)
    {
        $this->em            = $manager;

        $this->boxRepository = $boxRepository;

    }

    /**
     * @Route("/admin/nos-box",
     *     name="admin.gestion.box.list")
     * @Security("has_role('ROLE_GERANT')")
     */
    public function listBox()
    {

        $boxes = $this->boxRepository->findAllBoxes();

        return $this->render("box/box-list.html.twig", [
            'boxes' => $boxes
        ]);
    }

    /**
     * @Route("/admin/nos-box/create",
     *     name="admin.gestion.box.create")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createBox(Request $request)
    {
        $box = new Box();

        $form = $this->createForm(BoxCreationType::class, $box)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /**
             * @var uploadedFile $image
             */
            $image = $box->getImage();

            if(null !== $image)
            {
                $imageName = sha1($box->getName()).'.'.$image->guessExtension();

                try {
                    $image->move($this->getImageDirectory(), $imageName);
                } catch (FileException $e) {
                    throw new FileException("Impossible de télécharger l'image");
                }

                $box->setImage($imageName);

                ## set the current user as creator


                $this->em->persist($box);

                $this->em->flush();

                # Notification
                $this->addFlash(
                    'notice',
                    'Félicitation votre a été créée !'
                );

                # Redirection vers l'article crée
                return $this->redirectToRoute("admin.gestion.box.show", [
                    'id' => $box->getId()
                ]);
            }
            else{
                $this->addFlash("warning", "Veuillez Choisir une image d'illustration !");
            }
        }

        return $this->render("box/box-create.html.twig", [
            'form'   => $form->createView()
        ]);

    }

    /**
     * @param Box $box
     * @Route("/admin/nos-box/show/{id}", name="admin.gestion.box.show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBox(Box $box = null)
    {
        if (null === $box) {
            # on redirige l'utilisateur sur la page index
            /* throw $this->createNotFoundException(
                 "Nous n'avons pas trouvé l'article associé à l'id : " .$id
             );*/
            return $this->redirectToRoute('admin.gestion.box.list', [], Response::HTTP_MOVED_PERMANENTLY);
        }

        /*if ($box->getId() !== $id) {
            return $this->redirectToRoute('admin.gestion.box.list');
        }*/

        return $this->render("box/box-show.html.twig", [
            'box'  => $box
        ]);
    }

    /**
     * @param Box $box
     * @param Request $request
     * @param Packages $packages
     *
     * @Route("/admin/nos-box/update/{id}",
     *     name="admin.gestion.box.update",
     *     methods={"GET", "POST"}
     * )
     * @return Response
     */
    public function updateBox(Box $box, Request $request, Packages $packages)
    {
        $options = [
            'image_url' => $packages->getUrl('images/products/'.$box->getImage())
        ];

        #Récupération de l'image de base
        $imageBase = $box->getImage();

        $box->setImage(
            new File($this->getParameter('images_box').'/'.$box->getImage())
        );

        $form = $this->createForm(BoxCreationType::class, $box, $options)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            #dump($article);
            # 1. Traitement de l'upload de l'image

            /**
             * récupération de la nouvelle image, si elle a été modifiée
             * @var UploadedFile $newImage
             */
            $newImage = $box->getImage();

            if (null !== $newImage) {
                $imageName = sha1($box->getName()) . '.' . $newImage->guessExtension();


                try {
                    $newImage->move(
                        $this->getParameter('images_box'),
                        $imageName
                    );
                } catch (FileException $e) {

                }

                # Mise à jour de l'image
                $box->setImage($imageName);

            } else {
                $box->setImage($imageBase);
            }

            # 3. Sauvegarde en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($box);
            $em->flush();

            # 4. Notification
            $this->addFlash('notice',
                'Félicitation, votre box a été créée !');


            return $this->render("box/box-show.html.twig", [
                'box' => $box,
                'form' => $form->createView()
            ]);
        }

        return $this->render("box/box-update.html.twig", [
            'form'  => $form->createView()
        ]);
    }


    public function getImageDirectory()
    {
        return $this->imageDirectory = $this->getParameter('images_box');
    }

    public function uploadImage(UploadedFile $uploadedFile)
    {


        return $uploadedFile->getFilename();
    }



}