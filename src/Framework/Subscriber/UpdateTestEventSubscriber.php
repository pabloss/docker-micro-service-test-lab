<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
use App\Framework\Subscriber\Event\AfterSavingTestEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateTestEventSubscriber  implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterSavingTestEvent::NAME => 'onSavingTest',
        ];
    }

    public function onSavingTest(AfterSavingTestEvent $event)
    {
        $uService = $this->em->getRepository(UService::class)->findByHash($event->getUuid());
        /** @var Test $test */
        $test = $this->em->getRepository(Test::class)->findByHash($event->getUuid());

        if(null !== $test && null !== $uService) {
            $test->setUService($uService);
        }
    }
}
