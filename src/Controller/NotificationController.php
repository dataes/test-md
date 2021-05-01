<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Notification;
use App\Entity\NotificationBlock;
use App\Entity\NotificationBlockContent;
use App\Form\NotificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/", name="notification")
     */
    public function index(Request $request): Response
    {
        $notification = new Notification();
        $notificationBlock = new NotificationBlock();
        $notificationBlockContent = new NotificationBlockContent();

        $languages = $this->getDoctrine()
            ->getRepository(Language::class)
            ->findAll();

        $notificationBlockContent->addLanguages($languages);
        $notificationBlock->addNotificationBlockContent($notificationBlockContent);
        $notification->addNotificationBlock($notificationBlock);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($notification);
        $entityManager->persist($notificationBlock);
        $entityManager->persist($notificationBlockContent);

        $form = $this->createForm(NotificationType::class, $notification);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification = $form->getData();
            $notificationBlock->setNotification($notification);
            $notificationBlockContent->setNotificationBlock($notificationBlock);

            $entityManager->persist($notification);
            $entityManager->flush();
        }

        return $this->render(
            'notification/index.html.twig', [
            'form' => $form->createView(),
            'languages' => $languages
        ]);
    }
}
