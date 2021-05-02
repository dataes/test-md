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
        [$notification, $notificationBlock, $languages, $notificationBlockContent, $entityManager] =
            $this->createNotification();

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
            ]
        );
    }

    /**
     * @return array
     */
    private function createNotification(): array
    {
        $notification = new Notification();
        $notificationBlock = new NotificationBlock();
        $languages = $this->getDoctrine()
            ->getRepository(Language::class)
            ->findAll();

        foreach ($languages as $language) {
            // many to many relation however one language per content (it could have been a OneToMany)
            $notificationBlockContent = new NotificationBlockContent();
            $notificationBlockContent->addLanguage($language);
            $notificationBlock->addNotificationBlockContent($notificationBlockContent);
            $notification->addNotificationBlock($notificationBlock);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($notification);
        $entityManager->persist($notificationBlock);
        $entityManager->persist($notificationBlockContent);

        return [$notification, $notificationBlock, $languages, $notificationBlockContent, $entityManager];
    }
}
