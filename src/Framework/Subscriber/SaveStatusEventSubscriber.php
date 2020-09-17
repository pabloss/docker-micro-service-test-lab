<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\AppCore\Domain\Service\SaveStatus;
use App\Framework\Subscriber\Event\SaveStatusEvent;

class SaveStatusEventSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /** @var SaveStatus */
    private $saveStatusService;

    /**
     * SaveStatusEventSubscriber constructor.
     *
     * @param SaveStatus $saveStatusService
     */
    public function __construct(SaveStatus $saveStatusService)
    {
        $this->saveStatusService = $saveStatusService;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SaveStatusEvent::NAME => 'onSaveStatus',
        ];
    }

    public function onSaveStatus(SaveStatusEvent $event)
    {
        $this->saveStatusService->save($event->getStatusEntity()->getUuid(), $event->getStatusEntity()->getStatusName(), $event->getStatusEntity()->getCreated());
    }
}
