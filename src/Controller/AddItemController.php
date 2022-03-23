<?php

namespace App\Controller;

use App\Entity\Cards;
use App\Form\CardsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AddItemController extends AbstractController
{
    #[Route('/add', name: 'app_add')]
    public function index(Request $request,EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {

            $card =  new Cards;

            $form = $this->createForm(CardsType::class,$card);
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($card);

                $brochureFile = $form->get('images')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $brochureFile->move(
                            $this->getParameter('cards_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $card->setImages($newFilename);

                }
                $entityManager->flush();

            return $this->redirectToRoute('app_home');

            }

        



        return $this->render('add_item/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
