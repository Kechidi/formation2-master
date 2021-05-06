<?php

namespace App\Controller;

use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{

    /**
     * @Route("/formation",name="formation")
     */
    public function formation(FormationsRepository $formationRepository)
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll()
        ]);
    }
}
