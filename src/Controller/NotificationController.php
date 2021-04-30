<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\NotificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function index(): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);

        return $this->render('notification/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
