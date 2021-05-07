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
        $total=0;
        foreach ($panier as $id =>$quantity){
           $formation= $formationRepository->find($id);
            $prix =0;
            $panierWithData[]=[
                "formations"=>$formation,
                "quantity"=>$quantity,



            ];
            $total += $formation ->getPrix()*$quantity;
        }


        return $this->render('cart/index.html.twig',compact("panierWithData","total")

        );




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




    /**
     * @Route ("/panier/remove/{id}",name="cart_remove")
     */

    public function remove(Formations $formation,SessionInterface $session){


        //prendre un panier vide
        $panier  =$session->get('panier',[]);
        $id = $formation->getId();
//le remplir

        if(!empty($panier[$id])){
            if($panier[$id]>1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }



        }

        $session->set('panier',$panier);
        return $this->redirectToRoute("cart_index");


    }
    /**
     * @Route ("/panier/delette",name="cart_delette_all")
     */



    public function deletteAll(SessionInterface $session){


        //prendre un panier vide


$session->remove("panier");

                return $this->redirectToRoute("cart_index");


    }
    /**
     * @Route ("/panier/delette/{id}",name="cart_delette")
     */



    public function delette(Formations $formation,SessionInterface $session){


        //prendre un panier vide
        $panier  =$session->get('panier',[]);
        $id = $formation->getId();
//le remplir

        if(!empty($panier[$id])){
            if($panier[$id]>1){

                unset($panier[$id]);
            }



        }

        $session->set('panier',$panier);
        return $this->redirectToRoute("cart_index");


    }
}