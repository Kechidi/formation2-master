<?php

namespace App\Controller;

use App\Repository\FormationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProcederPaimentController extends AbstractController
{
    /**
     * @Route("/proceder/paiment", name="proceder_paiment")
     */
    public function index(SessionInterface $session,FormationsRepository $formationRepository): Response
    {


        $panier = $session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {

            $panierWithData[] = [
                'formations' => $formationRepository->find($id),
                'quantity' => $quantity

            ];
        }
        return $this->render('proceder_paiment/index.html.twig', [
            'items' => $panierWithData
        ]);
    }


    /**
     * @Route ("/p/add/{id}",name="p_add")
     */

    public function add($id,SessionInterface $session){


        //prendre un panier vide
        $panier  =$session->get('panier',[]);
//le remplir

        if(!empty($panier[$id])){
            $panier[$id]++;

        }else{
            $panier[$id]=1;
        }

        $session->set('panier',$panier);
        dd($session->get('panier'));

    }














}