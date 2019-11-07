<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\Framework\Application\DeployProcessApplication;
use App\Framework\Event\FileUploadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeployUnzippedDockerSubscriber implements EventSubscriberInterface
{
    /**
     * @var DeployProcessApplication
     */
    private $deployProcessApplication;

    /**
     * DeployUnzippedDockerSubscriber constructor.
     * @param DeployProcessApplication $deployProcessApplication
     */
    public function __construct(DeployProcessApplication $deployProcessApplication)
    {
        $this->deployProcessApplication = $deployProcessApplication;
    }


    public static function getSubscribedEvents()
    {
        return [
            FileUploadedEvent::NAME => ['onUploadedFile', -10]
        ];
    }

    public function onUploadedFile(FileUploadedEvent $event)
    {
        $this->deployProcessApplication->deploy($event->getPhpFiles());
    }

}
