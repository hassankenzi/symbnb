<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/ads/{slug}/book", name="booking-create")
     * @IsGranted("ROLE_USER") 
     */
    public function book(Ad $ad, Request $request)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class,$booking);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $user =  $this->getUser();
             
            $booking->setBooker($user)
                    ->setAd($ad);
        //si les  dates ne sont pas disponibles, message d'erreur
        if(!$booking->isBookableDates()){
            $this->addFlash('warning', "les dates que vous aves choisi elle sont déja prises. ");
        }else{
            
            //sinon enregistregistrement et redirection 
        }
        
                    $this->em->persist($booking);
                    $this->em->flush();
                    return $this->redirectToRoute('booking_show', ['id' => $booking->getId(), 'withAlert' => true]);

        }
        return $this->render('booking/book.html.twig', [
            'ad'   => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page d'une  réservation
     * @Route("/booking/{id}", name="booking_show")
     *
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking){
        return $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}
