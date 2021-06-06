<?php

namespace App\Controller;

use App\Entity\Detail;

use App\Form\DetailType;
use App\Form\FormationType;

use App\Repository\DetailRepository;
use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailFormationController extends AbstractController
{
    /**
     * @Route("/detail/formation", name="detail_formation")
     */
    public function formation(DetailRepository $detailRepository,FormationsRepository $formationRepository): Response
    {

        $form = $this->createForm(DetailType::class);

        return $this->render('detail_formation/lirePlus.html.twig', [
            'formations' => $formationRepository->findAll(),
            'form' => $form->createView()

        ]);

    }


    /**
     * @Route("/detail/formation2", name="detail")
     */
    public function formation2(DetailRepository $detailRepository,FormationsRepository $formationRepository): Response
    {

        $form = $this->createForm(DetailType::class);
        return $this->render('detail_formation/lirePlus.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
