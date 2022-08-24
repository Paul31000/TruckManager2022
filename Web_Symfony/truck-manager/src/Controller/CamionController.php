<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Camion;
use App\Form\CamionformType;

class CamionController extends AbstractController
{

    

    /**
    * @Route("/camion", name="app_camion")
    * @param Request $request
    */
    public function camion(Request $request):response
    {
        
        
        $nouveauCamion = new Camion();
        $form = $this->createForm(CamionformType::class,$nouveauCamion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($nouveauCamion);
            $em->flush();
        }
        
        $repository   = $this->getDoctrine()->getRepository(Camion::class);
        $listeCamion  = $repository->findAll();
        return $this->render('camion.html.twig', [
            'listeCamion' => $listeCamion,
            'form' => $form->createView()
            ]);
    }

    /**
    * @Route("/deletecamion", name="deletecamion")
    * @param Request $request
    */
    public function deleteAction(Request $request):response
    {
        $em = $this->getDoctrine()->getManager();
        $adminentities = $em->getRepository(Camion::class)->find($request->get('id'));

        $em->remove($adminentities);
        $em->flush();   

        return $this->redirectToRoute('app_camion');
    }

}
