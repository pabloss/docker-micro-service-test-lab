<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use App\Framework\Application\UnpackZippedFileApplication;
use App\Framework\Event\FileUploadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UnpackFileSubscriber implements EventSubscriberInterface
{
    /**
     * @var UnpackZippedFileApplication
     */
    private $unpackZippedFileApplication;

    /**
     * @var WrappedContext
     */
    private $context;

    /**
     * UnpackFileSubscriber constructor.
     * @param UnpackZippedFileApplication $unpackZippedFileApplication
     * @param WrappedContext $context
     */
    public function __construct(UnpackZippedFileApplication $unpackZippedFileApplication, WrappedContext $context)
    {
        $this->unpackZippedFileApplication = $unpackZippedFileApplication;
        $this->context = $context;
    }


    public static function getSubscribedEvents()
    {
        return [
            FileUploadedEvent::NAME => ['onUploadedFile', 10]
        ];
    }

    /**
     * @param FileUploadedEvent $event
     * @throws \ZMQSocketException
     */
    public function onUploadedFile(FileUploadedEvent $event)
    {
        $params = $this->unpackZippedFileApplication->unzipToTargetDir($event->getPhpFiles());
        $this->context->send(\array_merge($params->toArray(), ['index' => $params->getTargetDir()]));
    }

}
