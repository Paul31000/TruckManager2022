<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Camion;
use App\Entity\Camionstatus;
use App\Entity\PositionHistory;
use Symfony\Component\HttpFoundation\Request;

class MapController extends AbstractController
{
    /**
    * @Route("/map", name="map_generale")
    */
    public function map()
    {
        $repository   = $this->getDoctrine()->getRepository(Camion::class);
        $listeCamion  = $repository->findAllWithRelationNotNull();
        return $this->render('map.html.twig', [
                    'listeCamion' => $listeCamion,
                    ]);
    }
    /**
    * @Route("/mapcamion/{id}", name="mapcamion")
    */
    public function mapcamion(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $camion = $em->getRepository(Camion::class)->find($id);
        $positionHistory = $em->getRepository(PositionHistory::class)->findPositionHistory($id);
        return $this->render('mapCamion.html.twig', [
                    'camion' => $camion,
                    'positionHistory'=> $positionHistory,
                    ]);
    }

    /**
    * @Route("/deletestatus", name="deletestatus")
    * @param Request $request
    */
    public function deleteStatus(Request $request):response
    {
        $em = $this->getDoctrine()->getManager();
        $camionStatus = $em->getRepository(Camionstatus::class)->find($request->get('idStatus'));
        $camion = $em->getRepository(Camion::class)->find($request->get('idCamion'));
        $arrayHistory=$camion->getPositionHistories();
    
        $repoPosition = $em->getRepository(PositionHistory::class);
        foreach($arrayHistory as $position){
            $repoPosition->remove($position);
        }
        $em->remove($camionStatus);
        $em->flush();   

        return $this->redirectToRoute('map_generale');
    }
}
