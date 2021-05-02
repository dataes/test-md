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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
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

    /**
     * @var Session
     */
    private $session;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        $this->em = $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock();

        $this->controller = new NotificationController($this->em);

        $this->languageRepository = $this->getMockBuilder(ObjectRepository::class)->disableOriginalConstructor(
        )->getMock();

        $this->form = $this->getMockBuilder(FormInterface::class)->disableOriginalConstructor()->getMock();

        $this->request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();

        $this->container = $this->getMockBuilder(ContainerInterface::class)->disableOriginalConstructor()->getMock();
        $this->controller->setContainer($this->container);

        $this->formFactory = $this->getMockBuilder(FormFactory::class)->disableOriginalConstructor()->getMock();

        $this->twig = $this->getMockBuilder(Environment::class)->disableOriginalConstructor()->getMock();

        $this->session = $this->getMockBuilder(Session::class)->disableOriginalConstructor()->getMock();

        $this->flashBag = $this->getMockBuilder(FlashBagInterface::class)->disableOriginalConstructor()->getMock();

        $this->router = $this->getMockBuilder(Router::class)->disableOriginalConstructor()->getMock();
    }

    public function testIndex()
    {
        $language1 = new Language();
        $language1->setIsoCode('en');

        $language2 = new Language();
        $language2->setIsoCode('fr');

        $languages = [$language1, $language2];

        $this->em
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo(Language::class))
            ->willReturn($this->languageRepository);

        $this->languageRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$language1, $language2]);

        $notification = new Notification();
        $notificationBlock = new NotificationBlock();
        // content per languages
        foreach ($languages as $language) {
            $notificationBlockContent = new NotificationBlockContent();
            $notificationBlockContent->addLanguage($language);
            $notificationBlock->addNotificationBlockContent($notificationBlockContent);
            $notification->addNotificationBlock($notificationBlock);
        }

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

        $this->container
            ->expects($this->any())
            ->method('has')
            ->willReturn(true);

        $this->container
            ->expects($this->exactly(2))
            ->method('get')
            ->willReturnOnConsecutiveCalls($this->formFactory, $this->twig);

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

        $result = $this->controller->index($this->request);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function testIndexSubmitted()
    {
        $language1 = new Language();
        $language1->setIsoCode('en');

        $language2 = new Language();
        $language2->setIsoCode('fr');

        $languages = [$language1, $language2];

        $this->em
            ->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo(Language::class))
            ->willReturn($this->languageRepository);

        $this->languageRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$language1, $language2]);

        $notification = new Notification();
        $notificationBlock = new NotificationBlock();
        // content per languages
        foreach ($languages as $language) {
            $notificationBlockContent = new NotificationBlockContent();
            $notificationBlockContent->addLanguage($language);
            $notificationBlock->addNotificationBlockContent($notificationBlockContent);
            $notification->addNotificationBlock($notificationBlock);
        }

        $this->em
            ->expects($this->exactly(4))
            ->method('persist');

        $this->form
            ->expects($this->once())
            ->method('handleRequest')
            ->with($this->equalTo($this->request));

        $this->form
            ->expects($this->once())
            ->method('isSubmitted')
            ->willReturn([true]);

        $this->form
            ->expects($this->once())
            ->method('isValid')
            ->willReturn([true]);

        $this->form
            ->expects($this->once())
            ->method('getData')
            ->willReturn($notification); // notification populated from the form

        $this->em
            ->expects($this->once())
            ->method('flush');

        $this->container
            ->expects($this->exactly(1))
            ->method('has')
            ->willReturn(true);

        $this->container
            ->expects($this->exactly(3))
            ->method('get')
            ->willReturnOnConsecutiveCalls($this->formFactory, $this->session, $this->router);

        $this->session
            ->expects($this->once())
            ->method('getFlashBag')
            ->willReturn($this->flashBag);

        $this->flashBag
            ->expects($this->once())
            ->method('add')
            ->with(
                $this->equalTo('notice'),
                $this->equalTo('Notification enregistré !')
            );

        $this->formFactory
            ->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo('App\Form\NotificationType'),
                $this->equalTo($notification)
            )
            ->willReturn($this->form);

        $this->router
            ->expects($this->once())
            ->method('generate')
            ->willReturn('/');

        $result = $this->controller->index($this->request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals(302, $result->getStatusCode());
    }
}
