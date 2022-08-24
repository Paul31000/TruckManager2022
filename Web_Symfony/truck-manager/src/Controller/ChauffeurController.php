<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Chauffeur;
use App\Entity\Camionstatus;
use App\Form\ChauffeurformType;

class ChauffeurController extends AbstractController
{
    /**
     * @Route("/chauffeur", name="app_chauffeur")
     * @param Request $request
     */
    public function chauffeur(Request $request):response
    {
        
        $nouveauChauffeur = new Chauffeur();
        $form = $this->createForm(ChauffeurformType::class,$nouveauChauffeur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($nouveauChauffeur);
            $em->flush();
        }
        $repository   = $this->getDoctrine()->getRepository(Chauffeur::class);
        $listeChauffeur  = $repository->findAll();
        return $this->render('chauffeur.html.twig', [
            'listeChauffeur' => $listeChauffeur,
            'form' => $form->createView()
            ]);
    }

    /**
    * @Route("/deletechauffeur", name="deletechauffeur")
    * @param Request $request
    */
    public function deleteAction(Request $request):response
    {
        $em = $this->getDoctrine()->getManager();
        $adminentities = $em->getRepository(Chauffeur::class)->find($request->get('id'));
        $em->remove($adminentities);
        $em->flush();   

        return $this->redirectToRoute('app_chauffeur');
    }
}
