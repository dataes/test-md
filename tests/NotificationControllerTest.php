<?php

namespace App\Tests;

use App\Controller\NotificationController;
use App\Entity\Language;
use App\Entity\Notification;
use App\Entity\NotificationBlock;
use App\Entity\NotificationBlockContent;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class NotificationControllerTest extends TestCase
{
    /**
     * @var EntityManagerInterface|MockObject
     */
    private $em;

    /**
     * @var NotificationController
     */
    private $controller;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var Environment
     */
    private $twig;

    public function setUp(): void
    {
        $this->em = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();

        $this->controller = new NotificationController($this->em);

        $this->languageRepository = $this->getMockBuilder(ObjectRepository::class)->disableOriginalConstructor()->getMock();

        $this->form = $this->getMockBuilder(FormInterface::class)->disableOriginalConstructor()->getMock();

        $this->request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();

        $this->container = $this->getMockBuilder(ContainerInterface::class)->disableOriginalConstructor()->getMock();
        $this->controller->setContainer($this->container);

        $this->formFactory = $this->getMockBuilder(FormFactory::class)->disableOriginalConstructor()->getMock();

        $this->twig = $this->getMockBuilder(Environment::class)->disableOriginalConstructor()->getMock();
    }

    public function testIndex()
    {
        $notification = new Notification();
        $language1 = new Language();
        $language1->setIsoCode('en');
        $language2 = new Language();
        $language2->setIsoCode('fr');

        $this->em
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo(Language::class))
            ->willReturn($this->languageRepository);

        $this->languageRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$language1, $language2]);

        // content per languages
        $notificationBlockContent1 = new NotificationBlockContent();
        $notificationBlockContent2 = new NotificationBlockContent();
        $notificationBlockContent1->addLanguage($language1);
        $notificationBlockContent2->addLanguage($language2);

        $notificationBlock = new NotificationBlock();
        $notificationBlock->addNotificationBlockContent($notificationBlockContent1);
        $notificationBlock->addNotificationBlockContent($notificationBlockContent2);

        $notification->addNotificationBlock($notificationBlock);

        $this->em
            ->expects($this->exactly(3))
            ->method('persist');


        $this->form
            ->expects($this->once())
            ->method('handleRequest')
            ->with($this->equalTo($this->request));

        $this->form
            ->expects($this->once())
            ->method('isSubmitted')
            ->willReturn([false]);

//        $this->container
//            ->expects($this->once())
//            ->method('get')
//            ->with($this->equalTo('form.factory'))
//            ->willReturn($this->formFactory);

        $this->container
            ->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls($this->formFactory, $this->twig);
// todo : why it goes into ; if (!$this->container->has('twig'))


        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo('App\Form\NotificationType'),
                $this->equalTo($notification)
            )
            ->willReturn($this->form);

        $this->form
            ->expects($this->never())
            ->method('getData');

//        $this->container
//            ->expects($this->once())
//            ->method('get')
//            ->with($this->equalTo('twig'))
//            ->willReturn($this->twig);

        $result = $this->controller->index($this->request);
//dump($result->getDate());die();
//        $this->assertInstanceOf(TwigResponse::class, $result);
    }
}
