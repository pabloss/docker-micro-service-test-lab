<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\Framework\Entity\Status;
use App\Framework\Entity\UService;
use App\Framework\Subscriber\Event\AfterSavingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateStatusEventSubscriber implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * UpdateStatusEventSubscriber constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterSavingService::NAME => 'onUpdateStatus',
        ];
    }

    public function onUpdateStatus(AfterSavingService $event)
    {
        $entities = $this->em->getRepository(Status::class)->findByHash($event->getUuid());

        \array_walk($entities, function (Status $status) use ($event) {
            $status->setUService($this->em->getRepository(UService::class)->findByHash($event->getUuid()));
            $this->em->flush();
        });
    }
}
