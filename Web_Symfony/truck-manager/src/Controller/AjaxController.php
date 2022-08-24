<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax", name="app_ajax")
     */
    public function index(): Response
    {
        return $this->render('ajax/index.html.twig', [
            'controller_name' => 'AjaxController',
        ]);
    }

    /**                                                                                   
     * @Route("/requête_camion_id", name="_recherche_ajax")
     */
    public function ajaxAction(Request $request)    
    {
        if ($request->isXMLHttpRequest()) {         
            return new JsonResponse(array('data' => 'this is a json response'));
        }

        return new Response('This is not ajax!', 400);
    }
}
