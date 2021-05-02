<?php

namespace App\Controller;

use App\Entity\Language;
use App\Entity\Notification;
use App\Entity\NotificationBlock;
use App\Entity\NotificationBlockContent;
use App\Form\NotificationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * NotificationController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="notification")
     */
    public function index(Request $request): Response
    {
        [$notification, $notificationBlock, $languages, $notificationBlockContent] =
            $this->createNewNotification();

        $form = $this->createForm(NotificationType::class, $notification);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification = $form->getData();
            $notificationBlock->setNotification($notification);
            $notificationBlockContent->setNotificationBlock($notificationBlock);

            $this->em->persist($notification);
            $this->em->flush();

            $this->addFlash(
                'notice',
                'Notification enregistré !'
            );

            return $this->redirectToRoute('notification');
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
    private function createNewNotification(): array
    {
        $notification = new Notification();
        $notificationBlock = new NotificationBlock();
        $languages = $this->em
            ->getRepository(Language::class)
            ->findAll();

        foreach ($languages as $language) {
            // many to many relation however one language per content (it could have been a OneToMany)
            $notificationBlockContent = new NotificationBlockContent();
            $notificationBlockContent->addLanguage($language);
            $notificationBlock->addNotificationBlockContent($notificationBlockContent);
            $notification->addNotificationBlock($notificationBlock);
        }

        $this->em->persist($notification);
        $this->em->persist($notificationBlock);
        $this->em->persist($notificationBlockContent);

        return [$notification, $notificationBlock, $languages, $notificationBlockContent];
    }
}
