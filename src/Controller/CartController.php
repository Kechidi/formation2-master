<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Repository\FormationsRepository;


use SessionIdInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session,FormationsRepository $formationRepository): Response
    {

        $panier  =$session->get('panier',[]);
        $panierWithData=[];
        foreach ($panier as $id =>$quantity){

            $panierWithData[]=[
                'formations'=>$formationRepository->find($id),
                'quantity'=>$quantity

            ];
        }


        return $this->render('cart/index.html.twig',[
            'items'=>$panierWithData
        ]);




    }

    /**
     * @Route ("/panier/add/{id}",name="cart_add")
     */

    public function add(Formations $formation,SessionInterface $session){


        //prendre un panier vide
        $panier  =$session->get('panier',[]);
        $id = $formation->getId();
//le remplir

        if(!empty($panier[$id])){
            $panier[$id]++;

        }else{
            $panier[$id]=1;
        }

        $session->set('panier',$panier);
        return $this->redirectToRoute("cart_index");


    }
}