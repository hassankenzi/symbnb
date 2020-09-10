<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads_index")
     */
    public function index(AdRepository $repo, $page = 1)
    {
        $limit = 10;
        $start = $page*$limit - $limit;
        $total = count($repo->findAll());
        $pages = ceil($total / $limit);

        return $this->render('admin/ad/index.html.twig', [
            'ads' => $repo->findAll([], [], $limit, $start),
            'pages' => $pages,
            'page' => $page 
        ]);
    }

    /**
     * permet d'afficher la fourmulaire d'édition
     * @Route("/admin/ads/{id}/edit", name="admin_ads_edit")
     * @param Ad $ad
     * @return Response
     */
    public function edit(Ad $ad){
         $form=$this->createForm(AdType::class, $ad);
         return $this->render('admin/ad/edit.html.twig',[
             'ad'=> $ad,
             'form'=> $form->createView()

         ]);        
    }

}

