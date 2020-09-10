<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_booking_index")
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin_booking/index.html.twig', [
            'bookings' => $repo->findAll()
        ]);
    }

    /**
     * permet d'editer une réservation
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     * @param Booking $booking
     * @return Respose
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager){
        $form= $this->createForm(AdminBookingType::class, $booking);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();

            $this->addFlash(
                'success', "La réservation a bien été modifiée"
            );
            return $this->redirectToRoute("admin_booking_index");
        }

        return $this->render('admin/booking/edit.html.twig',[
            'form' => $form->createView(),
            'booking' => $booking
        ]);
    }

    /**
     * permet de suprimer une réservation
     * @Route("/admin/bookings/{id}/delete", name="admin_booking_delete")
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager){
        $manager->remove($booking);
        $manager->flush();
        $this->addFlash(
            'success', "La réservation a bien été supprimée"
        );
        return $this->redirectToRoute("admin_booking_index");
    }
} 
