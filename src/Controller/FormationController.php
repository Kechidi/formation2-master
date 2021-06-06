<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Form\FormationType;
use App\Repository\FormationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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




    /**
     * @Route("/formation/create", name="create")
     */
    public function create(Request $request): Response
    {
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        $formations = new Formations();
        $form= $this->createForm(FormationType::class,$formations);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formations);
            $entityManager->flush();
            return $this->redirectToRoute('formation');
        }

        return $this->render('formation/detail.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formation/update/{id}", name="update")
     */
    public function update(Request $request): Response
    {
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }


        $formation= $this->getDoctrine()->getManager()->getRepository(Formations::class)->findBy([
            'id'=> $request->attributes->get('id'),
        ]);

        $form= $this->createForm(FormationType::class,$formation[0]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation= $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();
            return $this->redirectToRoute('formation');
        }

        return $this->render('formation/detail.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/formation/delete/{id}", name="delete")
     */
    public function delete(Request $request): Response

    {
        if(! $this->getUser()){
            $this->addFlash('error','Vous devez vous connecter pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }



        $entityManager = $this->getDoctrine()->getManager();
        $formation = $this->getDoctrine()->getManager()->getRepository(Formations::class)->findBy([
            'id'=> $request->attributes->get('id'),
        ]);
        $entityManager->remove($formation[0]);
        $entityManager->flush();

        return $this->redirectToRoute('formation');
    }

}




