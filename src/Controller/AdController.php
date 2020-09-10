<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdSearch;
use App\Form\AdSearchType;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/ads", name="ads_index")
     * @return Response
     */
    public function index(AdRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $serch = new AdSearch();

        $form = $this->createForm(AdSearchType::class,$serch);
        $form->handleRequest($request);
        $ads = $paginator->paginate(
            $repo->findAllVisibleQuery($serch),
            $request->query->getInt('page', 1), 10
        );
        // $ads = $repo->findAll();
        
        return $this->render('ad/index.html.twig', [
            'ads'  => $ads,
            'form' => $form->createView()
  
            
            ]);
    }
        
    /**
     * permet de créer une annonce
     * @Route("/ads/new", name="ads_create")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(Request $request){
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                                
            $ad->setAuthor($this->getUser());
            $this->em->persist($ad);
            $this->em->flush();

            $this->addFlash( 
            'success',
            "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show',[
                'slug'=> $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    /**
     * permet d'afficher la formulaire d'édition
     * 
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * @Security("is_granted('ROLE_USER') and user == ad.getAuthor()", message= "cette annonce ne vous appartient pas")
     * @return Response
     */
    public function edit(Ad $ad, Request $request){
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $this->em->persist($ad);
            $this->em->flush();

            $this->addFlash( 
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
                );
    
                return $this->redirectToRoute('ads_show',[
                    'slug'=> $ad->getSlug()
                ]);
            }

        return $this->render('ad/edit.html.twig',[
            'form' => $form->createView(),
            'ad'  => $ad
        ]);   

    }

    /**
     * Permet d'afficher une seule annonce  
     *
     * @return Response
     * @Route("/ads/{slug}" ,name="ads_show")
     */
    public function show( Ad $ad){

        return $this->render('ad/show.html.twig',[
            'ad'=> $ad
         ]);
    }

    /**
     * pérmit de supprimer une annonce
     * @Route("/ads/{slug}/delete", name="ads_delete")
     * @Security("is_granted('ROLE_USER') and user == ad.getAuthor()",message="Vous n'avez pas le doit d'accéder à cette ressource")
     * @return Response
     */
    public function delete(Ad $ad){
        $this->em->remove($ad);
        $this->em->flush();

        $this->addFlash( 
            'success',
            "L'annonce <strong>{$ad->getTitle()}</strong> a bien été supprimée !");

        return $this->redirectToRoute("ads_index");
    }
   
}
 