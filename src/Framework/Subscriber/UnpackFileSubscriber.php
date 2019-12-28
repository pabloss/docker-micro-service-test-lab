<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use App\AppCore\Domain\Service\WebSockets\WrappedContextInterface;
use App\Framework\Application\UnpackZippedFileApplication;
use App\Framework\Application\UnpackZippedFileApplicationInterface;
use App\Framework\Event\FileUploadedEvent;
use App\Framework\Event\FileUploadedEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class UnpackFileSubscriber
 *
 * @package App\Framework\Subscriber
 * @codeCoverageIgnore
 */
class UnpackFileSubscriber implements EventSubscriberInterface, UnpackFileSubscriberInterface
{
    /**
     * @var UnpackZippedFileApplicationInterface
     */
    private $unpackZippedFileApplication;

    /**
     * @var WrappedContextInterface
     */
    private $context;

    /**
     * UnpackFileSubscriber constructor.
     *
     * @param UnpackZippedFileApplicationInterface $unpackZippedFileApplication
     * @param WrappedContextInterface              $context
     */
    public function __construct(UnpackZippedFileApplicationInterface $unpackZippedFileApplication, WrappedContextInterface $context)
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
     * @param FileUploadedEventInterface $event
     *
     * @throws \ZMQSocketException
     */
    public function onUploadedFile(FileUploadedEventInterface $event)
    {
        $params = $this->unpackZippedFileApplication->unzipToTargetDir($event->getPhpFiles());
        $this->context->send(\array_merge($params->toArray(), ['index' => $params->getTargetDir()]));
    }

}
