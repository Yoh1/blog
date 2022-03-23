<?php

namespace App\Controller;

use App\Entity\Cards;
use App\Repository\CardsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardsController extends AbstractController
{
    #[Route('/cards/{id}', name: 'app_cards')]
    public function index(int $id,CardsRepository $cardsRepository): Response
    {

        return $this->render('cards/index.html.twig', [
           'cartes' => $cardsRepository->find($id),
        ]);
    }
}
